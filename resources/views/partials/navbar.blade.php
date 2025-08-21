<!-- Navbar -->
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<div class="container position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restaurant</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="{{ url('/') }}" class="nav-item nav-link active">Ev</a>
                <a href="#hakkimiz-section" class="nav-item nav-link">Hakkında</a>
                <a href="{{ route('menu.index') }}" class="nav-item nav-link">Menü</a>
                <a href="#irtibat-section" class="nav-item nav-link">İrtibat</a>
            </div>

            <!-- Giriş / Kayıt / Profil -->
            <div class="d-flex">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Giriş Yap</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Kayıt Ol</a>
                @endguest

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profilim</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.resarvation') }}">Rezervasyonlarım</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Siparişlerim</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Çıkış Yap</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth


            </div>
        </div>
    </nav>
</div>

<!-- Footer altına içerik gelince mesafe bırakmak için örnek -->
<div style="height: 100px; background-color: #0F172B;"></div>
