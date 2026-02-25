<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Panggil CSS dari folder public --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-card">
        <h2>Login to your account</h2>

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="register-link">
        Belum punya akun?
        <a href="/register">Daftar di sini</a>
    </div>
        <div class="footer-text">
            Sistem Informasi Pelayanan Desa Boro
        </div>
    </div>

</body>
</html>
