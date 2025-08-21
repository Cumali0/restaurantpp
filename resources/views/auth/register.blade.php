

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Restaurant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF için meta -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Heebo', sans-serif;
            background: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay {
            position: absolute;
            top:0; left:0;
            width:100%;
            height:100%;
            background: rgba(0,0,0,0.6);
            z-index: 1;
        }

        .register-card {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
            padding: 40px 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        .register-card h2 {
            color: #ff6b6b;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 10px rgba(255,107,107,0.2);
        }

        .btn-primary {
            border-radius: 50px;
            background: linear-gradient(to right, #ff6b6b, #f06595);
            border: none;
            padding: 12px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #f06595, #ff6b6b);
            transform: scale(1.05);
        }

        .register-card a {
            color: #ff6b6b;
            text-decoration: none;
        }

        .register-card a:hover {
            text-decoration: underline;
        }

        .alert-danger {
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .position-relative i {
            position: absolute;
            top: 12px;
            left: 15px;
            color: #ff6b6b;
        }

        .ps-5 { padding-left: 45px !important; }

        @media(max-width:576px){
            .register-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
<div class="overlay"></div>

<div class="register-card">
    <h2><i class="fas fa-user-plus me-2"></i>Kayıt Ol</h2>

    @if($errors->any())
        <div class="alert alert-danger text-start">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="position-relative">
            <i class="fas fa-user"></i>
            <input type="text" name="name" class="form-control ps-5" placeholder="Ad" required>
        </div>

        <div class="position-relative">
            <i class="fas fa-user"></i>
            <input type="text" name="surname" class="form-control ps-5" placeholder="Soyad" required>
        </div>

        <div class="position-relative">
            <i class="fas fa-phone"></i>
            <input type="text" name="phone" class="form-control ps-5" placeholder="Telefon" required>
        </div>

        <div class="position-relative">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control ps-5" placeholder="Emailiniz" required>
        </div>

        <div class="position-relative">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" class="form-control ps-5" placeholder="Şifre" required>
        </div>

        <div class="position-relative">
            <i class="fas fa-lock"></i>
            <input type="password" name="password_confirmation" class="form-control ps-5" placeholder="Şifreyi Tekrar" required>
        </div>

        <button type="submit" class="btn btn-primary mb-3">Kayıt Ol</button>

        <p>Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a></p>
    </form>


</div>

</body>
</html>
