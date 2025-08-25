@extends('layouts.app')

@section('title', $category->name . ' - Menü')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h5 class="section-title ff-secondary text-primary fw-normal">{{ $category->name }}</h5>
            <h1 class="mb-4">Kalite</h1>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm text-center">
                        @if($product->img)
                            <img src="{{ asset('storage/' . $product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }} ₺</p>
                            <p class="card-text">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center mt-4">Bu kategoride henüz ürün bulunmamaktadır.</p>
            @endforelse
        </div>
    </div>
@endsection
