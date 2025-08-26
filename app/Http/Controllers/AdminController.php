<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Giriş verilerini doğrula
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Giriş denemesi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Sadece admin (id = 1) giriş yapabilir
            if ($user->role_id != 1) {
                Auth::logout();
                return back()->withErrors(['email' => 'Sadece admin giriş yapabilir.']);
            }


            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Başarısız giriş
        return back()->withErrors(['email' => 'Email veya şifre hatalı!'])->withInput();
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login');
    }

    public function showLoginForm()
    {
        return view('admin.login.index'); // Login sayfanın blade dosyası
    }
}
