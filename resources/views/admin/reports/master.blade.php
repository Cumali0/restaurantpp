<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.4; }
        h2, h3 { margin: 0 0 10px 0; }
        .section { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .card { padding: 10px; margin-bottom: 10px; border-radius: 5px; color: #fff; }
        .card-primary { background-color: #007bff; }
        .card-success { background-color: #28a745; }
        .card-warning { background-color: #ffc107; color: #000; }
    </style>
</head>
<body>

<h2>{{ ucfirst($type) }} Rapor ({{ $start->format('d-m-Y') }} - {{ $end->format('d-m-Y') }})</h2>

<div class="section">
    <div class="card card-primary">Toplam Sipariş: {{ $orders->count() }}</div>
    <div class="card card-success">Toplam Rezervasyon: {{ $reservations->count() }}</div>
    <div class="card card-warning">Toplam Gelir: {{ number_format($totalRevenue,2) }}₺</div>
</div>

<div class="section">
    <h3>Siparişler</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Tarih</th>
            <th>Toplam</th>
            <th>Ürünler</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->order_time->format('d-m-Y H:i') }}</td>
                <td>{{ number_format($order->total_price,2) }}₺</td>
                <td>
                    @foreach($order->items as $item)
                        {{ $item->product->name }} ({{ $item->quantity }})<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Rezervasyonlar</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Müşteri</th>
            <th>Telefon</th>
            <th>Tarih</th>
            <th>Kişi Sayısı</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservations as $res)
            <tr>
                <td>{{ $res->id }}</td>
                <td>{{ $res->name }} {{ $res->surname }}</td>
                <td>{{ $res->phone }}</td>
                <td>{{ $res->datetime->format('d-m-Y H:i') }}</td>
                <td>{{ $res->people }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="section">
    <h3>En Çok Satılan Ürünler</h3>
    <table>
        <thead>
        <tr>
            <th>Ürün</th>
            <th>Satış Adedi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topProducts as $tp)
            <tr>
                <td>{{ $tp->product->name }}</td>
                <td>{{ $tp->total_quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
