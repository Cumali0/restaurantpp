@extends('layouts.app')

@section('content')
    <h2>Siparişlerim</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>Henüz siparişiniz bulunmuyor.</p>
    @else
        @foreach($orders as $order)
            <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; border-radius:8px;">
                <strong>Sipariş ID:</strong> {{ $order->id }} <br>
                <strong>Rezervasyon:</strong> {{ $order->reservation->name ?? 'Bilinmiyor' }} <br>
                <strong>Tarih:</strong> {{ $order->created_at->format('d/m/Y H:i') }} <br>
                <strong>Durum:</strong> {{ $order->status }} <br>
                <strong>Toplam:</strong> {{ number_format($order->total_price, 2) }}₺ <br>

                <a href="{{ route('orders.show', $order->id) }}" style="color:#007bff;">Detayları Gör</a> |


                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">İptal Et</button>
                </form>
            </div>
        @endforeach
    @endif
@endsection
