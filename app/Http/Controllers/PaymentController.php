<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran setelah booking
     */
    public function showPaymentPage($bookingId)
    {
        $booking = Booking::where('booking_id', $bookingId)->firstOrFail();
        $payment = Payment::where('booking_id', $bookingId)->first();

        if (!$payment || !$payment->amount || $payment->amount <= 0) {
            return redirect()->back()->with('error', 'Jumlah pembayaran tidak valid.');
        }

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // 🆕 Buat order_id unik + simpan ke DB
        $orderId = 'ORDER-' . $booking->booking_id . '-' . uniqid();
        $payment->update(['order_id' => $orderId]);   // simpan order_id
        $booking->update(['order_id' => $orderId]);   // jika booking juga simpan

        $callbackUrl = route('midtrans.callback');

        Log::info('Override callback URL:', [$callbackUrl]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => number_format($payment->amount, 2, '.', ''),
            ],
            'customer_details' => [
                'first_name' => $booking->customer_name ?? 'Customer',
                'email'      => $booking->customer_email ?? 'customer@example.com',
            ],
            'item_details' => [[
                'id'       => $booking->booking_id,
                'price'    => (int) $payment->amount,
                'quantity' => 1,
                'name'     => 'Booking ' . $booking->booking_id,
            ]],
            // pakai variabel yang baru
            'override_notification_url' => [
                $callbackUrl
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat pembayaran.');
        }

        $totalPrice = $payment->amount;

        return view('booking.payment', compact('snapToken', 'totalPrice'));
    }


    

    /**
     * Endpoint untuk menerima webhook dari Midtrans
     */
    public function midtransNotification(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $notification = new Notification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;
        $paymentType       = $notification->payment_type ?? null;

        Log::info('📥 Midtrans Webhook Received', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::warning('⚠️ Payment with order_id not found: ' . $orderId);
            return response()->json(['message' => 'Payment not found'], 200); // tetap 200 agar tidak diulang-ulang
        }

        // Ubah status tergantung status transaksi
        $status = match ($transactionStatus) {
            'settlement', 'capture' => 'paid',
            'pending', 'challenge' => 'pending',
            'cancel', 'deny', 'expire' => 'failed',
            default => $payment->status,
        };

        $payment->update([
            'status' => $status,
            'payment_status' => $transactionStatus,
            'payment_method' => $paymentType,
        ]);

        Log::info('✅ Payment updated: ' . $orderId . ' to status ' . $status);

        return response()->json(['message' => 'OK']);
    }

}
