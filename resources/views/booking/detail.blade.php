@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detail Pemesanan</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Informasi Booking -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pemesan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nama:</strong> {{ $name ?? '-' }}</li>
                        <li class="list-group-item"><strong>Alamat:</strong> {{ $address ?? '-' }}</li>
                        <li class="list-group-item"><strong>No. HP:</strong> {{ $phone ?? '-' }}</li>
                        <li class="list-group-item"><strong>Tujuan:</strong> {{ $booking->service->service_name ?? '-' }}</li>
                        <li class="list-group-item"><strong>Detail Tujuan:</strong> {{ $destinationDetail ?? '-' }}</li>
                        <li class="list-group-item"><strong>Kendaraan:</strong> {{ $booking->vehicle->name ?? '-' }}</li>
                        <li class="list-group-item"><strong>Tanggal Penjemputan:</strong> {{ \Carbon\Carbon::parse($booking->pickup_date)->translatedFormat('d F Y') }}</li>
                        <li class="list-group-item"><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d F Y') }}</li>
                        <li class="list-group-item"><strong>Jam Penjemputan:</strong> {{ $booking->pickup_time }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                    <p><strong>Total Pembayaran:</strong> <span class="text-success fw-bold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span></p>
                    <p>
                        <strong>Status Pembayaran:</strong>
                        @php
                            $status = $payment->payment_status;
                            $badge = match($status) {
                                'pending' => 'warning',
                                'paid', 'settlement' => 'success',
                                'cancelled', 'expire', 'deny' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }} text-uppercase">{{ $status }}</span>
                    </p>

                    @if ($status === 'pending' && $snapToken)
                        <div class="mt-3">
                            <p class="text-muted small">Klik tombol di bawah untuk melanjutkan pembayaran melalui Midtrans:</p>
                            <button id="pay-button" class="btn btn-outline-primary w-100">Bayar Sekarang</button>
                        </div>
                    @elseif ($status === 'paid' || $status === 'settlement')
                        <div class="alert alert-success mt-3 text-center">
                            <i class="bi bi-check-circle-fill"></i> Pembayaran berhasil!
                        </div>
                    @elseif ($status === 'cancelled' || $status === 'expire')
                        <div class="alert alert-danger mt-3 text-center">
                            <i class="bi bi-x-circle-fill"></i> Pembayaran gagal atau dibatalkan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Button Lihat Riwayat -->
    <div class="text-center mt-4">
        <a href="{{ route('history') }}" class="btn btn-secondary">
            <i class="bi bi-clock-history me-1"></i> Lihat Riwayat Pemesanan
        </a>
    </div>
</div>
@endsection

@if ($snapToken)
    @section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran berhasil!");
                    location.reload();
                },
                onPending: function(result){
                    alert("Pembayaran sedang diproses.");
                },
                onError: function(result){
                    alert("Terjadi kesalahan saat pembayaran.");
                }
            });
        });
    </script>
    @endsection
@endif
