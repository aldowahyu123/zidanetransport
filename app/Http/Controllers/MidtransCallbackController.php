<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Payment;

class MidtransCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {

        Log::info('🔥 [Midtrans] Callback reached', $request->all());

        $n = $request->all();                        // notifikasi asli sebagai array

        /* ------------------------------------------------------------------
         | 1. Validasi JSON & field wajib
         * -----------------------------------------------------------------*/
        foreach (['order_id', 'status_code', 'gross_amount', 'signature_key'] as $key) {
            if (! isset($n[$key])) {
                Log::error("[Midtrans] Incomplete data: missing {$key}");
                return response()->json(['message' => 'Incomplete data'], 400);
            }
        }

        /* ------------------------------------------------------------------
         | 2. Verifikasi Signature
         * -----------------------------------------------------------------*/
        $serverKey   = config('midtrans.server_key');
        $mySignature = hash('sha512',
            $n['order_id'] .
            $n['status_code'] .
            // pastikan gross_amount selalu '12345.00', dua desimal
            number_format((float) $n['gross_amount'], 2, '.', '') .
            $serverKey
        );

        if ($mySignature !== $n['signature_key']) {
            Log::error('[Midtrans] Signature mismatch', [
                'expected' => $mySignature,
                'received' => $n['signature_key'],
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        /* ------------------------------------------------------------------
         | 3. Temukan booking
         * -----------------------------------------------------------------*/
        $orderId = $n['order_id'];

        // → Jika order‑id DIKELUARKAN aplikasi: "ORDER-87-65ee...", cari id‑nya
        $bookingId = null;
        if (str_starts_with($orderId, 'ORDER-')) {
            // ambil segmen kedua (index 1)
            $bookingId = explode('-', $orderId, 3)[1] ?? null;
        }

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::warning("⚠️ Payment not found: $orderId");
            return response()->json(['message'=>'Payment not found'],200);
        }

        $booking = $payment->booking;
        if (!$booking) {
            Log::warning("⚠️ Booking missing for payment ".$payment->id);
            return response()->json(['message'=>'Booking not found'],200);
        }

        $txStatus   = $n['transaction_status'];
        $paymentTag = [
            'capture'    => 'paid',
            'settlement' => 'paid',
            'pending'    => 'pending',
            'challenge'  => 'pending',
            'deny'       => 'cancelled',
            'cancel'     => 'cancelled',
            'expire'     => 'cancelled',
        ][$txStatus] ?? $booking->status;

        DB::transaction(function () use ($booking, $payment, $paymentTag, $txStatus, $n) {
            $booking->update(['status' => $paymentTag]);

            $payment->update([
                'status'         => $paymentTag,
                'payment_status' => $txStatus,
                'payment_method' => $n['payment_type'] ?? null,
            ]);
        });

        Log::info('✅ Callback processed', [
            'booking_id' => $booking->booking_id,
            'status'     => $paymentTag,
        ]);
        return response()->json(['message'=>'OK']);

}}
