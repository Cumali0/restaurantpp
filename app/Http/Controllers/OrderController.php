<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Kullanıcının tüm siparişlerini göster
    public function index()
    {
        $orders = [
            [
                'id' => 1,
                'total' => 150,
                'status' => 'Hazırlanıyor',
                'items' => [
                    ['name' => 'Pizza', 'quantity' => 1],
                    ['name' => 'Kola', 'quantity' => 2],
                ],
            ],
            [
                'id' => 2,
                'total' => 190,
                'status' => 'Teslim Edildi',
                'items' => [
                    ['name' => 'Burger', 'quantity' => 2],
                    ['name' => 'Patates', 'quantity' => 1],
                ],
            ],
        ];

        return view('user.orders.index', compact('orders'));
    }

    // Sipariş detayını göster
    public function show($id)
    {
        $order = [
            'id' => $id,
            'total' => 150,
            'status' => 'Hazırlanıyor',
            'items' => [
                ['name' => 'Pizza', 'quantity' => 1, 'price' => 100],
                ['name' => 'Kola', 'quantity' => 2, 'price' => 25],
            ],


            'id' => $id,
            'total' => 190,
            'status' => 'Hazırlanıyor',
            'items' => [
                ['name' => 'Burger', 'quantity' => 2, 'price' => 70],
                ['name' => 'Patates', 'quantity' => 1, 'price' => 50],
            ],
        ];

        return view('user.orders.show', compact('order'));
    }
}
