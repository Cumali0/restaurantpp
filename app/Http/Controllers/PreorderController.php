<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PreorderController extends Controller
{
    // Ön sipariş sayfası
    public function reservationPreorder($token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::with('items.product')->firstOrCreate(
            ['reservation_id' => $reservation->id],
            ['token' => $token, 'total_price' => 0]
        );
        $categories = Category::with('products')->get();

        return view('reservations.preorder', compact('categories', 'cart', 'reservation'));
    }

    // Sepete ekle
    public function addToCart(Request $request, $token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::firstOrCreate(
            ['reservation_id' => $reservation->id],
            ['token' => $token, 'total_price' => 0]
        );

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total_price' => $product->price * $request->quantity,
            ]);
        }

        $cart->load('items.product');
        $this->updateCartTotal($cart);

        return response()->json(['success' => true, 'cart' => $cart->load('items.product')]);
    }

    // Sepet item güncelle (miktar)
    public function updateCartItem(Request $request, $token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::with('items')->where('reservation_id', $reservation->id)->firstOrFail();

        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::findOrFail($request->cart_item_id);
        $item->quantity = $request->quantity;
        $item->total_price = $item->quantity * $item->price;
        $item->save();

        $this->updateCartTotal($cart);

        return response()->json(['success' => true, 'cart' => $cart->load('items.product')]);
    }

    // Sepetten ürün çıkar
    public function removeFromCart(Request $request, $token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::with('items.product')->where('reservation_id', $reservation->id)->firstOrFail();

        $request->validate(['cart_item_id' => 'required|exists:cart_items,id']);
        $item = CartItem::findOrFail($request->cart_item_id);
        $item->delete();

        $cart->load('items.product');
        $this->updateCartTotal($cart);

        return response()->json(['success' => true, 'cart' => $cart->load('items.product')]);
    }

    // Sepeti boşalt
    public function emptyCart($token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::with('items')->where('reservation_id', $reservation->id)->firstOrFail();
        $cart->items()->delete();
        $cart->delete();

        return response()->json(['success' => true]);
    }

    // Ön siparişi tamamla
    public function finalizePreorder(Request $request, $token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::with('items')->where('reservation_id', $reservation->id)->firstOrFail();

        if ($cart->items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Sepetiniz boş!']);
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'reservation_id' => $reservation->id,
                'total_price' => $cart->total_price,
                'status' => 'pending',
                'order_time' => now(),
                'payment_type' => $request->payment ?? 'Banka'
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total_price' => $item->total_price,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sipariş başarıyla tamamlandı!',
                'redirect_url' => route('payment.page', ['order' => $order->id])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Sipariş tamamlanamadı.']);
        }
    }

    // Sepeti getir
    public function getCart($token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $cart = Cart::with('items.product')->where('reservation_id', $reservation->id)->first();

        return response()->json(['items' => $cart ? $cart->items : []]);
    }

    private function updateCartTotal(Cart $cart)
    {
        $cart->total_price = $cart->items->sum('total_price');
        $cart->save();
    }


}
