@extends('admin.layouts.app')

@section('title', 'Profilim')

@section('content')
    <div class="profile-container">
        <h2>👤 Profil Güncelle</h2>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf

            <div class="mb-3">
                <label for="name">İsim</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="old_password">Mevcut Şifre</label>
                <input type="password" name="old_password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password">Yeni Şifre</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Yeni Şifre (Tekrar)</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>

    <style>
        .profile-container {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 600px;
            width: 90%;
            background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
            padding: 45px 50px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 0.03em;
            transition: box-shadow 0.3s ease;
        }

        .profile-container:hover {
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        .profile-container h2 {
            font-weight: 900;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-size: 2.2rem;
            text-align: center;
            position: relative;
            letter-spacing: 0.05em;
        }

        .profile-container h2::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: #2563eb;
            border-radius: 3px;
            margin: 10px auto 0;
            box-shadow: 0 0 10px #2563ebaa;
        }

        .profile-container label {
            font-weight: 600;
            color: #444;
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .profile-container .form-control {
            width: 100%;
            border-radius: 15px;
            border: 1.8px solid #cbd5e1;
            padding: 14px 20px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            outline: none;
            box-sizing: border-box;
            color: #222;
            background-color: #f9fbff;
        }

        .profile-container .form-control::placeholder {
            color: #a0aec0;
            font-style: italic;
        }

        .profile-container .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 12px rgba(37, 99, 235, 0.6);
            background-color: #ffffff;
        }

        .profile-container .alert-success {
            border-left: 6px solid #22c55e;
            background-color: #dcfce7;
            color: #166534;
            padding: 16px 22px;
            border-radius: 12px;
            font-weight: 600;
            margin-bottom: 28px;
            box-shadow: 0 2px 12px rgba(34, 197, 94, 0.25);
        }

        .profile-container .alert-danger {
            border-left: 6px solid #ef4444;
            background-color: #fee2e2;
            color: #991b1b;
            padding: 16px 22px;
            border-radius: 12px;
            font-weight: 600;
            margin-bottom: 28px;
            box-shadow: 0 2px 12px rgba(239, 68, 68, 0.25);
        }

        .profile-container .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .profile-container .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border: none;
            padding: 16px 40px;
            font-size: 1.2rem;
            border-radius: 25px;
            font-weight: 800;
            letter-spacing: 0.05em;
            transition: background 0.35s ease, box-shadow 0.35s ease, transform 0.25s ease;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.5);
            cursor: pointer;
            user-select: none;
            display: block;
            width: 100%;
            margin-top: 24px;
        }

        .profile-container .btn-primary:hover,
        .profile-container .btn-primary:focus {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            box-shadow: 0 14px 35px rgba(30, 64, 175, 0.7);
            outline: none;
            transform: scale(1.05);
        }

        .profile-container .mb-3 {
            margin-bottom: 2rem;
        }


    </style>

@endsection
