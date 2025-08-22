<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcı giriş yaptı mı ve admin mi?
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
