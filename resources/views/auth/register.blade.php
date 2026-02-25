<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-card">
        <h2>Buat Akun Baru</h2>

        <form method="POST" action="/register">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-register">Daftar</button>
        </form>

        <div class="register-link">
            Sudah punya akun?
            <a href="/login">Login di sini</a>
        </div>

        <div class="footer-text">
            Sistem Informasi Pelayanan Desa Boro
        </div>
    </div>

</body>
</html>
