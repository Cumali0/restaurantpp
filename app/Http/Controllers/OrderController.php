<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
public function index()
{
$orders = Order::with('reservation')
->whereHas('reservation', fn($q) => $q->where('user_id', auth()->id()))
->orderBy('created_at', 'desc')
->get();

return view('orders.index', compact('orders'));
}

public function show(Order $order)
{
$order->load('items.product');

// Kullanıcıya ait olup olmadığını kontrol et
if ($order->reservation->user_id !== auth()->id()) {
abort(403);
}

return view('orders.show', compact('order'));
}
}
