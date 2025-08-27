<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Giriş formunu göster
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // Giriş işlemi
    public function login(Request $request)
    {
        // Validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Eğer giriş yapan admin ise logout yap ve hata ver
            if (Auth::user()->role_id == 1) { // role_id = 1 => admin
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Bu alan sadece normal kullanıcılar içindir.'
                ]);
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Email veya şifre hatalı!'])->withInput();
    }

    // Çıkış işlemi
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
