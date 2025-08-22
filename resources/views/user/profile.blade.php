@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6" style="    margin-top: 110px;">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Profilim</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Ad </label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                            </div>


                            <div class="mb-3">
                                <label for="name" class="form-label">Soyad</label>
                                <input type="text" class="form-control" name="surname" value="{{ $user->surname }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-Posta</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label for="password" class="form-label">Yeni Şifre</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-success w-100">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
