@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Ödeme Sonucu</h2>

        @if($payment->getStatus() === 'success')
            <div class="bg-green-100 p-4 rounded border border-green-400 mb-4">
                <p class="font-bold text-green-700">Ödeme Başarılı ✅</p>
                <p>Siparişinizin faturası mail olarak gönderildi.</p>
            </div>
        @else
            <div class="bg-red-100 p-4 rounded border border-red-400 mb-4">
                <p class="font-bold text-red-700">Ödeme Başarısız ❌</p>
            </div>
        @endif

        <div class="mb-4">
            <p><strong>Sipariş ID:</strong> {{ $order->id }}</p>
            <p><strong>Tutar:</strong> {{ number_format($order->total_price, 2) }} TL</p>
            <p><strong>Conversation ID:</strong> {{ $payment->getConversationId() }}</p>
            <p><strong>Status:</strong> {{ $payment->getStatus() }}</p>
            @if($payment->getErrorMessage())
                <p class="text-red-600"><strong>Hata:</strong> {{ $payment->getErrorMessage() }}</p>
            @endif
        </div>

        <a href="{{ route('reservation.preorder', ['token' => $order->reservation->preorder_token]) }}" class="bg-gray-600 text-white px-4 py-2 rounded">Ön Siparişe Geri Dön</a>
    </div>
@endsection
