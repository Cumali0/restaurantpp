@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Sipariş #{{ $order['id'] }}</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered" style="
                width: 1200px;
                height: 100px;
                display: flex;                             ;
                flex-direction: column;
                flex-wrap: nowrap;">
                    <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Miktar</th>
                        <th>Fiyat</th>
                        <th>Toplam</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order['items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] ?? 0 }}₺</td>
                            <td>{{ ($item['price'] ?? 0) * $item['quantity'] }}₺</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <h5 class="text-end mt-3">Genel Toplam: {{ $order['total'] }}₺</h5>
            </div>
        </div>
    </div>
@endsection
