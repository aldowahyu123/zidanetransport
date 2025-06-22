@extends('layouts.guest')
@section('content')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white">
    <div class="text-center w-full max-w-md p-6">
        <!-- Foto Profil -->
        <div class="flex flex-col items-center justify-center mb-6">
            <div class="w-36 h-36 rounded-full bg-indigo-900 flex items-center justify-center overflow-hidden shadow-lg mb-4">
                @if(Auth::user() && Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <!-- Ikon user SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.969 9.969 0 0112 15c2.21 0 4.243.716 5.879 1.924M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                @endif
            </div>
            <h2 class="text-2xl font-bold text-black">{{ Auth::user()->name ?? 'gading' }}</h2>
            <p class="text-gray-700 text-lg">{{ Auth::user()->email ?? 'gading@example.com' }}</p>
        </div>

        <!-- Menu Profil -->
        <div class="bg-indigo-900 rounded-2xl px-8 py-6 shadow-lg text-left">
            <ul class="space-y-5 text-base font-medium text-white">
                <li class="border-b border-orange-400 pb-2 hover:text-orange-300 transition duration-150"><a href="/history">Riwayat Pesanan</a></li>
                <li class="border-b border-orange-400 pb-2 hover:text-orange-300 transition duration-150"><a href="#">Help and Support</a></li>
                <li class="border-b border-orange-400 pb-2 hover:text-orange-300 transition duration-150"><a href="#">Settings</a></li>
                <li class="border-b border-orange-400 pb-2 hover:text-orange-300 transition duration-150">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-orange-300 transition duration-150">
                        Logout
                    </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection