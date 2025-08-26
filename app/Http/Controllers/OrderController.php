<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('reservation')
            ->whereHas('reservation', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        if ($order->reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.orders.show', compact('order'));
    }

    // ---------------- EKLEMELER ----------------

    public function cancel(Order $order)
    {
        if ($order->reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $order->status = 'canceled';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Sipariş iptal edildi.');
    }


    public function continue(Order $order)
    {
        if ($order->reservation->user_id !== auth()->id()) abort(403);
        $cartItems = $order->items;
        return view('reservations.preorder', compact('cartItems', 'order'));
    }

    public function edit(Order $order)
    {
        if ($order->reservation->user_id !== auth()->id()) abort(403);
        $cartItems = $order->items;
        return view('reservations.preorder', compact('cartItems', 'order'));
    }


    public function preorderSave(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderId = $request->order_id ?? null;
        $cartItems = $request->cart_items;

        if ($orderId) {
            $order = Order::find($orderId);
            $order->items()->delete();
        } else {
            $order = new Order();
            $order->user_id = auth()->id();
        }

        $order->status = 'pending';
        $order->total_price = 0;
        $order->save();

        $total = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            $qty = $item['quantity'];
            $price = $product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $price,
                'total_price' => $price * $qty
            ]);

            $total += $price * $qty;
        }

        $order->total_price = $total;
        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Ön sipariş kaydedildi!');
    }
}
