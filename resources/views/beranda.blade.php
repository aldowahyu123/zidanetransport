@extends('layouts.guest')
@section('content')
    

<section class="bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
    <div class="px-12 max-w-screen-xl py-24 lg:py-56 w-3/4">
       <h1 class="text-white  text-3xl md:text-5xl font-extrabold mb-2 leading-14">Solusi Transportasi Terpercaya untuk Setiap Perjalanan Anda</h1>
        <p class="text-lg font-normal text-gray-300  mb-6"> Zidan Transport hadir sebagai solusi modern dalam memenuhi kebutuhan perjalanan Anda, baik pribadi maupun rombongan. Dengan sistem pemesanan yang mudah, armada nyaman, dan layanan profesional, kami siap menemani setiap langkah perjalanan Anda dengan aman dan tepat waktu.</p>
    </div>
</section>
<div class="px-12 py-6 space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">

  <!-- TUJUAN -->
  <div class="flex flex-col justify-center items-center text-center">
    <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full bg-primary-100">
      <!-- Map Pin Icon -->
      <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"></path>
      </svg>
    </div>
    <h3 class="mb-2 text-xl font-bold">Tujuan</h3>
    <p class="text-gray-500">Tentukan lokasi penjemputan dan tujuan akhir Anda dengan mudah. Sistem kami mendukung pemetaan lokasi secara akurat untuk memastikan titik penjemputan dan drop-off Anda sesuai dengan preferensi dan kebutuhan perjalanan.</p>
  </div>

  <!-- KENDARAAN -->
  <div class="flex flex-col justify-center items-center text-center">
    <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full bg-primary-100">
      <!-- Car Icon -->
      <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l1-3a2 2 0 012-1h12a2 2 0 012 1l1 3M5 13v4a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-4M7 16h.01M17 16h.01" />
      </svg>
    </div>
    <h3 class="mb-2 text-xl font-bold">Kendaraan</h3>
    <p class="text-gray-500">Pilih kendaraan yang sesuai dengan kebutuhan perjalanan Anda. Kami menyediakan berbagai jenis armada mulai dari mobil pribadi hingga ELF besar untuk perjalanan rombongan, lengkap dengan fasilitas dan kenyamanan terbaik.</p>
  </div>

  <!-- TANGGAL PEMESANAN -->
  <div class="flex flex-col justify-center items-center text-center">
    <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full bg-primary-100">
      <!-- Calendar Icon -->
      <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-10 4h10M5 7h14a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
      </svg>
    </div>
    <h3 class="mb-2 text-xl font-bold">Tanggal Pemesanan</h3>
    <p class="text-gray-500">Tentukan tanggal dan waktu keberangkatan Anda secara fleksibel. Sistem kami memungkinkan Anda memilih jadwal jauh hari dan memberikan notifikasi untuk memastikan Anda tidak melewatkan perjalanan penting.</p>
  </div>

</div>


<section class="w-[1100px] rounded-2xl h-72 bg-center flex items-center bg-no-repeat bg-indigo-900 bg-gray-700 bg-blend-multiply mx-auto">
    <div class="px-12 w-3/4">
       <h1 class="text-white  text-3xl md:text-5xl font-extrabold mb-2 leading-14">Siap bepergian hari ini </h1>
        <p class="text-lg font-normal text-gray-300  mb-6">Static websites are now used to bootstrap lots of websites and are becoming the basis for a variety of tools that even influence both web designers and developers.</p>
    </div>
</section>

@endsection