<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::attempt($credentials)) {
            Log::info('User logged in successfully: ' . Auth::user()->email);
            $request->session()->regenerate();

            // Langsung redirect ke route bernama 'redirect'
            return redirect()->route('redirect');
        }

        Log::error('Login failed for email: ' . $request->input('email'));
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Hapus method authenticated(), tidak dibutuhkan
}
