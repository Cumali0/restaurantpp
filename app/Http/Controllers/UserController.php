<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class UserController extends Controller
{
    public function myReservations()
    {
        $user = Auth::user();

        // Kullanıcının kendi rezervasyonları
        $reservations = Reservation::where('email', $user->email)
            ->orderBy('datetime', 'desc')
            ->get();

        return view('user.resarvation', compact('reservations'));
    }
}
