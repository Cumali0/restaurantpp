<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Kayıt formunu göster
    public function showRegistrationForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // Kayıt işlemi
    public function register(Request $request)

    {

        // Telefon kontrolü
        if (User::where('phone', $request->phone)->exists()) {
            return back()->withErrors(['phone' => 'Bu telefon numarası zaten kayıtlı.'])->withInput();
        }

        // Email kontrolü
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Bu email adresi zaten kayıtlı.'])->withInput();
        }


        // Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'Şifreler uyuşmuyor!',
        ]);

        // Kullanıcı oluştur
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // otomatik müşteri
        ]);

        // Oturum aç
        Auth::login($user);


        return redirect()->route('login')->with('success', 'Kayıt başarılı! Lütfen giriş yapın.');
    }
}
