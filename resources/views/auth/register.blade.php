<!DOCTYPE html>
<html>

<head>

    <title>Register</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body>

    <a href="/" class="back-btn">
        Kembali ke Dashboard
    </a>

    <div class="login-card">
        <div class="logo-area">
            <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa">
            <h2>Buat Akun Baru</h2>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">

            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" placeholder="Masukkan NIK" required>
            </div>

            <div class="form-group">
                <label>No. Telepon (WhatsApp)</label>
                <input type="text" name="phone" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-register">
                Daftar
            </button>

        </form>

        <div class="register-link">
            Sudah punya akun?
            <a href="/login">Login di sini</a>
        </div>

        <div class="footer-text">
            Sistem Informasi Pelayanan Desa Bloro
        </div>

    </div>

</body>
</html>