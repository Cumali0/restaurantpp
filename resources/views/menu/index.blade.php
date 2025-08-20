@extends('layouts.app')

@section('title', 'Menü - Restaurant')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h5 class="section-title ff-secondary text-primary fw-normal">Menümüz</h5>
            <h1 class="mb-4">Kategoriler</h1>
        </div>

        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('menu.products', $category->id) }}" class="text-decoration-none">
                        <div class="card h-100 text-center p-3 shadow-sm category-card">
                            @if($category->img)
                                <img src="{{ asset('img/' . $category->img) }}" class="card-img-top mb-3" alt="{{ $category->name }}">
                            @endif
                            <h5 class="card-title text-dark">{{ $category->name }}</h5>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .category-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
@endsection
