<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;      // <- Bunu ekle
use App\Models\OrderItem;  // diğer modeller zaten varsa sorun yok


class PaymentController extends Controller
{
    public function show(Order $order)
    {
        return view('payment', compact('order'));
    }
}
