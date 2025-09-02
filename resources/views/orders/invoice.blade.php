<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sipariş Faturası</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color:#333; font-size:12px; }
        table { width:100%; border-collapse: collapse; margin-bottom:20px; }
        th, td { border:1px solid #ddd; padding:6px; text-align:left; }
        th { background-color:#f0f0f0; }
        .center { text-align:center; }
        .right { text-align:right; }
        h2 { color:#2575fc; margin-bottom:10px; }
        img { display:block; margin:auto; }
    </style>
</head>
<body>
<h2>Merhaba {{ $order->reservation->name ?? 'Müşteri' }},</h2>
<p>Siparişiniz başariyla alinmiştir. Fatura detayları aşagidadir:</p>

<table>
    <thead>
    <tr>
        <th>Ürün</th>
        <th class="center">Fotoğraf</th>
        <th class="center">Adet</th>
        <th class="right">Fiyat</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items ?? [] as $item)
        <tr>
            <td>{{ $item->product->name ?? 'Ürün Bulunamadı' }}</td>
            <td class="center">
                @if($item->product->image)
                    <img src="{{ asset('storage/products/' . $item->product->image) }}" width="50" height="50">

                @else
                    -
                @endif
            </td>
            <td class="center">{{ $item->quantity ?? 0 }}</td>
            <td class="right">{{ number_format($item->total_price ?? 0,2) }} TL</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p class="right"><strong>Toplam Tutar: {{ number_format($order->total_price,2) }} TL</strong></p>

<p style="margin-top:20px; font-size:12px; color:#777;">
    Saygilarimizla,<br>
    <strong>{{ config('app.name') }}</strong>
</p>
</body>
</html>
