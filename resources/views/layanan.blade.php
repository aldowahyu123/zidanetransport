@extends('layouts.guest')

@section('content')

{{-- Jumbotron --}}
<section class="bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Informasi Layanan</h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
            Kami menyediakan berbagai pilihan layanan carteran dan antar jemput kendaraan yang fleksibel dan hemat, dirancang untuk berbagai jenis perjalanan Anda. Termasuk perjalanan ziarah wali dan antar kota yang nyaman dan terpercaya.
        </p>
        <p class="text-white text-lg font-semibold">
            Layanan kami mencakup berbagai wilayah dan jenis perjalanan sesuai kebutuhan Anda
        </p>
    </div>
</section>

{{-- Fitur Layanan --}}
<section class="bg-white py-16">
    <div class="max-w-4xl mx-auto px-4">
        <div class="space-y-8">

            <!-- Item 1 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">1</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Carteran Fleksibel Sesuai Kebutuhan</h3>
                    <p class="text-gray-700">Layanan carter kendaraan full day atau half day, cocok untuk perjalanan wisata, keluarga, atau rombongan kerja.</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">2</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Antar Jemput Bandara & Stasiun</h3>
                    <p class="text-gray-700">Kami siap menjemput dan mengantar Anda tepat waktu ke bandara, terminal, atau stasiun sesuai jadwal.</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">3</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Driver Berpengalaman & Ramah</h3>
                    <p class="text-gray-700">Pengemudi profesional yang mengenal rute lokal dengan baik, memastikan kenyamanan dan keamanan Anda.</p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">4</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Layanan Door to Door</h3>
                    <p class="text-gray-700">Kami menjemput Anda langsung dari rumah dan mengantar sampai tujuan tanpa repot pindah kendaraan.</p>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">5</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Kendaraan Bersih & Terawat</h3>
                    <p class="text-gray-700">Setiap unit kendaraan selalu kami jaga kebersihannya dan dicek rutin sebelum perjalanan agar tetap nyaman digunakan.</p>
                </div>
            </div>

            <!-- Item 6 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">6</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Pemesanan Mudah via Online</h3>
                    <p class="text-gray-700">Pesan layanan kapan saja dan di mana saja melalui website atau WhatsApp. Proses cepat dan tanpa ribet.</p>
                </div>
            </div>

            <!-- Item 7 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">7</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Harga Transparan & Kompetitif</h3>
                    <p class="text-gray-700">Tidak ada biaya tersembunyi! Harga sudah termasuk bahan bakar dan jasa sopir.</p>
                </div>
            </div>

            <!-- Item 8 -->
            <div class="flex items-start space-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold">8</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Customer Service Responsif</h3>
                    <p class="text-gray-700">Tim kami siap membantu Anda setiap hari, mulai dari informasi pemesanan hingga penanganan keluhan.</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Armada Kami --}}
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-12">Armada Kami</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Armada 1 -->
            <div class="bg-indigo-900 rounded-xl shadow-md p-6 flex flex-col items-center">
                <img src="{{ asset('img/xenia.png') }}" alt="Toyota Avanza 2015" class="w-full h-48 object-contain mb-4">
                <h3 class="text-xl font-bold text-white mb-4">DAIHATSU XENIA 2015</h3>
                <div class="flex items-center text-sm text-white space-x-4">
                    <span class="flex items-center">
                        <i class="fa-solid fa-calendar text-orange-500 mr-2"></i>2015
                    </span>
                    <span>|</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-id-card text-orange-500 mr-2"></i>W 1150 HI
                    </span>
                    <span>|</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-users text-orange-500 mr-2"></i>7
                    </span>
                </div>
            </div>

            <!-- Armada 2 -->
            <div class="bg-indigo-900 rounded-xl shadow-md p-6 flex flex-col items-center">
                <img src="{{ asset('img/xenia.png') }}" alt="Toyota Avanza 2015" class="w-full h-48 object-contain mb-4">
                <h3 class="text-xl font-bold text-white mb-4">DAIHATSU XENIA 2015</h3>
                <div class="flex items-center text-sm text-white space-x-4">
                    <span class="flex items-center">
                        <i class="fa-solid fa-calendar text-orange-500 mr-2"></i>2015</span>
                    <span>|</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-id-card text-orange-500 mr-2"></i>DK 1402 AAK</span>
                    <span>|</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-users text-orange-500 mr-2"></i>7</span>
                </div>
            </div>

            <!-- Armada 3 -->
            <div class="bg-indigo-900 rounded-xl shadow-md p-6 flex flex-col items-center">
                <img src="{{ asset('img/elf_short.png') }}" alt="Toyota Avanza 2015" class="w-full h-48 object-contain mb-4">
                <h3 class="text-xl font-bold text-white mb-4">IZUZU ELF</h3>
                <div class="flex items-center text-sm text-white space-x-4">
                    <span class="flex items-center">
                        <i class="fa-solid fa-calendar text-orange-500 mr-2"></i>1995
                    </span>
                    <span>|</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-id-card text-orange-500 mr-2"></i>AG 7612 EA
                    </span>
                    <span>|</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-users text-orange-500 mr-2"></i>16
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- Call to Action Booking --}}
<section class="bg-indigo-900 rounded-2xl mx-4 my-10 px-6 py-10 text-white relative overflow-hidden">
    <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8 items-center">
        <div>
            <h2 class="text-3xl font-bold mb-2">Butuh Mobil?</h2>
            <p class="text-2xl font-semibold mb-4">+62 82142951682</p>
            <p class="mb-4">
                🧩 Ingin konsultasi langsung soal layanan yang sesuai?<br>
                Hubungi tim kami sekarang atau klik <strong>[Pesan Sekarang]</strong> untuk langsung booking!
            </p>
            <a href="{{ route('booking.form') }}" target="_blank" class="inline-block bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded-md transition">
                Pesan Sekarang
            </a>
        </div>
        <div class="hidden md:block">
            <img src="{{ asset('img/foto_lokasi.jpg') }}" alt="foto_lokasi.jpg" class="w-full object-cover rounded-lg shadow-lg">
        </div>
    </div>
</section>



@endsection