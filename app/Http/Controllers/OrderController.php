<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('reservation')
            ->whereHas('reservation', fn($q) => $q->where('user_id', auth()->id()))
            ->latest()
            ->get();

        // Yarım kalan cartlar (order_id null)
        $pendingCarts = Cart::whereNull('order_id')
            ->whereHas('reservation', fn($q) => $q->where('user_id', auth()->id()))
            ->latest()
            ->get();

        return view('user.orders.index', compact('orders', 'pendingCarts'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        if ($order->reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->reservation->user_id !== auth()->id()) abort(403);

        $order->status = 'canceled';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Sipariş iptal edildi.');
    }


    public function continueCart(Cart $cart)
    {
        // Kullanıcı kontrolü
        if ($cart->reservation->user_id !== auth()->id()) abort(403);

        $cartItems = $cart->items->map(fn($item) => [
            'product_id' => $item->product_id,
            'name' => $item->product->name,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'cart_item_id' => $item->id,
        ]);

        $categories = Category::with('products')->get();

        return view('reservations.preorder', [
            'cartItems' => $cartItems,
            'reservation' => $cart->reservation,
            'cart' => $cart,   // cart objesini token için
            'categories' => $categories
        ]);
    }


    public function preorderSave(Request $request)
    {
        $cartId = $request->cart_id ?? null;
        $cartItems = $request->cart_items;

        if ($cartId) {
            $cart = Cart::find($cartId);
            $cart->items()->delete();
        } else {
            $cart = new Cart();
            $cart->reservation_id = $request->reservation_id;
        }

        $cart->save();

        foreach ($cartItems as $item) {
            OrderItem::create([
                'cart_id' => $cart->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity']
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Ön sipariş kaydedildi!');
    }
}
