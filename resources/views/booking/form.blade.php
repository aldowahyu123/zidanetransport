@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-100 to-indigo-200 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-2xl bg-indigo-900 text-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-3xl font-bold text-center mb-6 text-orange-400">Form Booking Carter ELF / Mobil</h2>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block font-semibold mb-1">Nama</label>
                <input type="text" name="name" id="name" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 placeholder-white placeholder-opacity-70 focus:outline-none" placeholder="Nama" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="address" class="block font-semibold mb-1">Alamat</label>
                <textarea name="address" id="address" rows="3" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 placeholder-white placeholder-opacity-70 focus:outline-none" placeholder="Alamat" required>{{ old('address') }}</textarea>
            </div>

            <div>
                <label for="phone" class="block font-semibold mb-1">Nomor HP</label>
                <input type="text" name="phone" id="phone" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 placeholder-white placeholder-opacity-70 focus:outline-none" placeholder="No. HP" value="{{ old('phone') }}">
            </div>

            <div>
                <label for="service_id" class="block font-semibold mb-1">Pilih Tujuan</label>
                <select name="service_id" id="service_id" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 focus:outline-none" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->service_id }}" {{ old('service_id') == $service->service_id ? 'selected' : '' }}>
                            {{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="destination_detail" class="block font-semibold mb-1">Detail Tujuan</label>
                <textarea name="destination_detail" id="destination_detail" rows="2" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 placeholder-white placeholder-opacity-70 focus:outline-none" placeholder="Detail Tujuan">{{ old('destination_detail') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="pickup_date" class="block font-semibold mb-1">Tanggal Penjemputan</label>
                    <input type="date" name="pickup_date" id="pickup_date" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 focus:outline-none" value="{{ old('pickup_date') }}" required>
                </div>

                <div>
                    <label for="end_date" class="block font-semibold mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 focus:outline-none" value="{{ old('end_date') }}" required>
                </div>
            </div>

            <div>
                <label for="pickup_time" class="block font-semibold mb-1">Jam Penjemputan</label>
                <input type="time" name="pickup_time" id="pickup_time" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 focus:outline-none" value="{{ old('pickup_time') }}" required>
            </div>

            <div>
                <label for="vehicle_id" class="block font-semibold mb-1">Pilih Kendaraan</label>
                <select name="vehicle_id" id="vehicle_id" class="w-full rounded-lg bg-orange-500 text-white px-4 py-2 focus:outline-none" required>
                    <option value="">-- Pilih --</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function fetchAvailableVehicles() {
        const pickup_date = $('#pickup_date').val();
        const end_date = $('#end_date').val();

        if (pickup_date && end_date) {
            $.ajax({
                url: "{{ route('vehicles.availability') }}",
                type: 'GET',
                data: { pickup_date, end_date },
                success: function(data) {
                    const $vehicleSelect = $('#vehicle_id');
                    $vehicleSelect.empty().append('<option value="">-- Pilih --</option>');

                    $.each(data, function(_, vehicle) {
                        const option = $('<option></option>').val(vehicle.id).text(vehicle.name);
                        if (!vehicle.is_available) option.attr('disabled', true).text(vehicle.name + ' (Tidak tersedia)');
                        if (vehicle.id == "{{ old('vehicle_id') }}") option.prop('selected', true);
                        $vehicleSelect.append(option);
                    });
                },
                error: function(xhr) {
                    alert('Gagal mengambil kendaraan: ' + (xhr.responseJSON?.error || 'Terjadi kesalahan.'));
                }
            });
        }
    }

    $('#pickup_date, #end_date').on('change', fetchAvailableVehicles);

    if ($('#pickup_date').val() && $('#end_date').val()) {
        fetchAvailableVehicles();
    }
});
</script>
@endsection
