<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body>

<div class="login-container">

    <a href="/" class="back-btn">
        Kembali ke Dashboard
    </a>

    <div class="login-card">

        <!-- LOGO -->
        <div class="logo-area">

            <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa">

            <h2>Login to Your Account</h2>

        </div>

        <!-- 🔥 ALERT SUCCESS -->
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- 🔥 ALERT ERROR -->
        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- 🔥 VALIDATION ERROR -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form method="POST" action="/login">

            @csrf

            <div class="form-group">

                <label>Email</label>

                <input type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>

            </div>

            <div class="form-group">

                <label>Password</label>

                <input type="password" name="password" placeholder="Masukkan password" required>

            </div>

            <button type="submit" class="btn-login">
                Login
            </button>

        </form>

        <!-- REGISTER -->
        <div class="register-link">

            Belum punya akun?

            <a href="/register">Daftar sekarang</a>

        </div>

        <!-- FOOTER -->
        <div class="footer-text">

            Sistem Informasi Pelayanan Desa Bloro

        </div>

    </div>

</div>

</body>
</html>