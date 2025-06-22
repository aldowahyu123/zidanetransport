<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Auth\LoginController;

// Halaman utama
Route::get('/', function () {
    return redirect('/beranda');
});


// Halaman beranda dan layanan
Route::get('/beranda', fn() => view('beranda'))->name('beranda');
Route::get('/layanan', fn() => view('layanan'))->name('layanan');
Route::get('/pesanan', fn() => view('booking'))->name('pesanan');

// Halaman guest
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// Callback Midtrans
Route::post('/payment/midtrans-callback', [MidtransCallbackController::class, 'handleCallback'])->name('midtrans.callback');


// Halaman yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    // Redirect role
    Route::get('/redirect', function () {
        $user = Auth::user();
        \Log::info("Redirecting user: {$user->email}");

        if ($user->email === 'gading@example.com') {
            return redirect('/admin');
        }

        return redirect()->route('booking.form');
    })->name('redirect');

    // Admin dashboard
    Route::middleware(['auth', 'auth.admin'])->group(function () {
        Route::get('/admin', fn() => redirect(\Filament\Facades\Filament::getUrl()))
            ->name('admin.dashboard');
    });

    // Booking dan payment
    Route::prefix('booking')->group(function () {
        Route::get('/', [BookingController::class, 'create'])->name('booking.form');
        Route::get('/{id}', [BookingController::class, 'show'])->name('booking.show');
        Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
    });

    Route::get('/payment/{bookingId}', [PaymentController::class, 'showPaymentPage'])->name('payment.page');
    Route::get('/history', [BookingController::class, 'history'])->name('history');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');


    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});

// API
Route::get('/vehicles/availability', [BookingController::class, 'vehiclesWithAvailability'])
    ->name('vehicles.availability');

