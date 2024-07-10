<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function proses_login(Request $request)
    {
        $key = 'login_attempts_' . $request->ip();
        $maxAttempts = 5;
        $decaySeconds = 300;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'login' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik",
            ]);
        }

        $request->validate([
            'nama' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('nama', 'password'), $request->filled('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        RateLimiter::hit($key, $decaySeconds);

        return back()->withErrors([
            'login' => 'Username atau Password salah',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
