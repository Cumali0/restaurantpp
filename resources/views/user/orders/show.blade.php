@extends('layouts.app')

@section('content')
    <h2>Sipariş Detayı #{{ $order->id }}</h2>
    <p><strong>Rezervasyon:</strong> {{ $order->reservation->name ?? 'Bilinmiyor' }}</p>
    <p><strong>Tarih:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Durum:</strong> {{ $order->status }}</p>
    <p><strong>Toplam:</strong> {{ number_format($order->total_price, 2) }}₺</p>

    <h3>Ürünler</h3>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
        <tr>
            <th style="border:1px solid #ccc; padding:8px;">Ürün</th>
            <th style="border:1px solid #ccc; padding:8px;">Adet</th>
            <th style="border:1px solid #ccc; padding:8px;">Birim Fiyat</th>
            <th style="border:1px solid #ccc; padding:8px;">Toplam</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td style="border:1px solid #ccc; padding:8px;">{{ $item->product->name }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ $item->quantity }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($item->price,2) }}₺</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($item->total_price,2) }}₺</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" style="display:inline-block; margin-top:20px; color:#007bff;">Geri</a>
@endsection
