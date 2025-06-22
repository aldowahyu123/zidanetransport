<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // Tampilkan form booking
    public function create()
    {
        $services = Service::all();
        $vehicles = Vehicle::all();
        return view('booking.form', compact('services', 'vehicles'));
    }

    // Simpan booking dan generate snap token Midtrans
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,service_id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:pickup_date',
            'pickup_time' => 'required|date_format:H:i',
            'name' => 'required|string|max:255',    // validasi nama
            'address' => 'required|string|max:500', // validasi alamat
            'phone' => 'nullable|string|max:20',
            'destination_detail' => 'nullable|string|max:1000',
        ]);

            // Ambil nilai tambahan
        $phone = $request->input('phone');
        $destinationDetail = $request->input('destination_detail');

        // Kamu bisa simpan ke log, session, atau gunakan sesuai kebutuhan tanpa simpan ke DB
        \Log::info('Booking additional info', [
            'phone' => $phone,
            'destination_detail' => $destinationDetail,
        ]);
        

            // Cek apakah pengguna sudah login
        $userId = auth()->id();
        if (!$userId) {
            \Log::error('Error: User is not authenticated.');
            return redirect()->back()->with('error', 'Anda harus login untuk membuat booking.');
        }

        // Cek apakah kendaraan sudah dibooking pada rentang tanggal tersebut
        $existingBooking = Booking::where('vehicle_id', $validated['vehicle_id'])
        ->whereIn('status', ['pending', 'active']) // hanya booking yang masih aktif/pending
        ->where(function ($query) use ($validated) {
            $query->whereBetween('pickup_date', [$validated['pickup_date'], $validated['end_date']])
                ->orWhereBetween('end_date', [$validated['pickup_date'], $validated['end_date']])
                ->orWhere(function ($query2) use ($validated) {
                    $query2->where('pickup_date', '<=', $validated['pickup_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                });
        })
        ->first();

        if ($existingBooking) {
        return redirect()->back()->withInput()->withErrors([
            'vehicle_id' => 'Mobil ini sudah dibooking pada tanggal tersebut. Silakan pilih tanggal atau mobil lain.',
        ]);
        }

    
        $service = Service::findOrFail($validated['service_id']);
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
    
        $priceMultiplier = $service->price_multiplier ?? 1;
        $totalAmount = $vehicle->base_price * $priceMultiplier;
    
        DB::beginTransaction();

        try {
            // Simpan booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'service_id' => $validated['service_id'],
                'vehicle_id' => $validated['vehicle_id'],
                'booking_date' => now(),
                'pickup_date' => $validated['pickup_date'],
                'end_date' => $validated['end_date'],
                'pickup_time' => $validated['pickup_time'],
                'status' => 'pending',
                'name' => $validated['name'],       // ambil dari input validasi
                'address' => $validated['address'],

            ]);
            
        
            \Log::info('Booking created', ['booking_id' => $booking->booking_id]);
        
            $orderId = 'ORDER-' . $booking->booking_id . '-' . uniqid();
        
            // 🔁 MIDTRANS CONFIG & GENERATE SNAP TOKEN SEBELUM SIMPAN PAYMENT
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
        
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $vehicle->id,
                        'price' => $vehicle->base_price * $priceMultiplier,
                        'quantity' => 1,
                        'name' => $vehicle->name,
                    ],
                ],
            ];
        
            $snapToken = \Midtrans\Snap::getSnapToken($params); // ✅ BUAT DULU snapToken-nya
            \Log::info('Generated Snap Token: ' . $snapToken);

        
            // ✅ Sekarang aman untuk simpan ke tabel payments
            $payment = Payment::create([
                'booking_id' => $booking->booking_id,
                'amount' => $totalAmount,
                'payment_status' => 'pending',
                'payment_date' => now(),
                'order_id' => $orderId,
                'payment_method' => 'cash',
                'snap_token' => $snapToken,
            ]);
        
            \Log::info('Payment created', ['payment_id' => $payment->payment_id]);
        
            DB::commit();

            session([
                'booking_name' => $validated['name'],
                'booking_address' => $validated['address'],
                'booking_phone' => $phone,
                'booking_destination_detail' => $destinationDetail,
            ]);
        
            return redirect()->route('booking.show', $booking->booking_id)
                             ->with('snapToken', $snapToken);
        
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error booking store: ' . $e->getMessage());
            return redirect()->route('booking.form')
                             ->with('error', 'Gagal memproses booking: ' . $e->getMessage());
        }
    }
        
    
    

    // ✅ Tampilkan detail booking (dengan opsi bayar)
    public function show($id)
    {
        $booking = Booking::with(['vehicle', 'service'])->findOrFail($id);
        $payment = Payment::where('booking_id', $booking->booking_id)->first();
        $snapToken = session('snapToken', $payment->snap_token ?? null);
        if (!$snapToken) {
            \Log::error('Snap Token is missing in show method', ['booking_id' => $id]);
        }

        $name = session('booking_name', null);
        $address = session('booking_address', null);
        $phone = session('booking_phone', null); // Pastikan data ini tersedia
        $destinationDetail = session('booking_destination_detail', null);// Pastikan data ini tersedia

        return view('booking.detail', compact('booking', 'payment', 'snapToken', 'name', 'address', 'phone', 'destinationDetail'));
    }



    public function vehiclesWithAvailability(Request $request)
    {
        $pickup_date = $request->input('pickup_date');
        $end_date = $request->input('end_date');

        if (!$pickup_date || !$end_date) {
            return response()->json(['error' => 'Tanggal penjemputan dan tanggal selesai wajib diisi'], 400);
        }

        $allVehicles = Vehicle::all();

        // Cari kendaraan yang sudah dibooking (pending/active) dalam rentang tanggal
        $unavailableVehicleIds = Booking::whereIn('status', ['pending', 'active'])
            ->where(function ($query) use ($pickup_date, $end_date) {
                $query->whereBetween('pickup_date', [$pickup_date, $end_date])
                    ->orWhereBetween('end_date', [$pickup_date, $end_date])
                    ->orWhere(function ($query2) use ($pickup_date, $end_date) {
                        $query2->where('pickup_date', '<=', $pickup_date)
                            ->where('end_date', '>=', $end_date);
                    });
            })
            ->pluck('vehicle_id')
            ->toArray();

        // Tandai kendaraan tersedia / tidak tersedia
        $vehicles = $allVehicles->map(function ($vehicle) use ($unavailableVehicleIds) {
            $vehicle->is_available = !in_array($vehicle->id, $unavailableVehicleIds);
            return $vehicle;
        });

        return response()->json($vehicles);
    }

    public function history()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('vehicle', 'user')->get();
        return view('history', compact('bookings'));
    }



}
