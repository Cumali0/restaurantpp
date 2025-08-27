<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcı giriş yapmış ve role_id = 1 ise admin kabul edelim
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // Yetkisi yoksa ana sayfaya veya 403 sayfasına yönlendir
        return redirect('/')->with('error', 'Bu sayfaya erişim yetkiniz yok.');
    }
}
