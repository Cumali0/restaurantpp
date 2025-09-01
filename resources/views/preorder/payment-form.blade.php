@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Ödeme Sayfası</h2>

        <form action="{{ route('preorder.pay', ['order' => $order->id]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Kart Sahibi</label>
                <input type="text" name="card_holder_name" value="{{ old('card_holder_name') }}" class="border p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Kart Numarası</label>
                <input type="text" name="card_number" value="{{ old('card_number') ?? '5528790000000008' }}" class="border p-2 w-full" required>
            </div>

            <div class="flex mb-4 space-x-4">
                <div>
                    <label class="block mb-1 font-semibold">Ay</label>
                    <input type="text" name="expire_month" value="{{ old('expire_month') ?? '12' }}" class="border p-2 w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Yıl</label>
                    <input type="text" name="expire_year" value="{{ old('expire_year') ?? '2030' }}" class="border p-2 w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">CVC</label>
                    <input type="text" name="cvc" value="{{ old('cvc') ?? '123' }}" class="border p-2 w-full" required>
                </div>
            </div>

            <div class="mb-4">
                <p class="font-semibold">Ödenecek Tutar: <span class="text-green-600 font-bold">{{ number_format($order->total_price, 2) }} TL</span></p>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Ödemeyi Yap</button>
        </form>
    </div>
@endsection
