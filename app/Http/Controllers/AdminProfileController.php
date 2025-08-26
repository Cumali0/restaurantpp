<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    // Profil sayfasını göster
    public function edit()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    // Profili güncelle
    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'old_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        // Şifre değiştiriliyorsa, eski şifre kontrolü yapılır
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $admin->password)) {
                return back()->withErrors(['old_password' => 'Eski şifre yanlış'])->withInput();
            }

            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile.update')->with('success', 'Profil güncellendi.');
    }
}
