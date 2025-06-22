@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Konfirmasi Pembayaran</h3>
    <p>Total Pembayaran: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>

    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                alert('Pembayaran berhasil');
                console.log("✅ Success", result);
                location.reload(); // Atau redirect ke halaman history
            },
            onPending: function (result) {
                alert('Menunggu pembayaran Anda');
                console.log("⏳ Pending", result);
            },
            onError: function (result) {
                alert('Pembayaran gagal');
                console.error("❌ Error", result);
            },
            onClose: function () {
                alert('Anda menutup halaman pembayaran tanpa menyelesaikannya');
            }
        });
    });
</script>
@endsection
