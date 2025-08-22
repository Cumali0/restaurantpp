<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('admin/login/css/login.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <h2>Admin Login</h2>
        <p class="subtitle">Please login to your account</p>
        <form id="loginForm" method="POST" action="{{ route('dashboard.login.post') }}">
            @csrf
            <div class="input-group">
                <span class="material-icons">email</span>
                <input type="email" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required />
            </div>
            <div class="input-group">
                <span class="material-icons">lock</span>
                <input type="password" id="password" name="password" placeholder="Password" required />
                <span class="material-icons visibility" id="togglePassword">visibility_off</span>
            </div>
            <div class="options">
                <label>
                    <input type="checkbox" id="rememberMe" name="remember" /> Remember Me
                </label>
                <a href="#" class="forgot">Forgot Password?</a>
            </div>
            <button type="submit" class="btn-login">Login</button>

            {{-- Backend hata mesajları --}}
            @if ($errors->any())
                <div class="message error show">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>
</div>
<script src="{{ asset('admin/login/js/login.js') }}"></script>
</body>
</html>
