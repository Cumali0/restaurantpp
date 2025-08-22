@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4" style="color:#0d6efd;">Siparişlerim</h2>

        <div class="table-responsive shadow rounded" style="background-color: rgba(255,255,255,0.95); padding:20px;">
            <table class="table table-hover align-middle mb-0"style="    width: 1200px;
    height: 100px;
    display: flex
;
    flex-direction: column;">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Toplam</th>
                    <th>Durum</th>
                    <th>Detay</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ $order['total'] }}₺</td>
                        <td>
                            @if($order['status'] == 'pending')
                                <span class="badge bg-warning text-dark">Beklemede</span>
                            @elseif($order['status'] == 'completed')
                                <span class="badge bg-success">Tamamlandı</span>
                            @elseif($order['status'] == 'canceled')
                                <span class="badge bg-danger">İptal</span>
                            @else
                                <span class="badge bg-secondary">{{ $order['status'] }}</span>
                            @endif
                        </td>
                        <td><a href="{{ route('orders.show', $order['id']) }}" class="btn btn-primary btn-sm">Detay</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
