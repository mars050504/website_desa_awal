<!DOCTYPE html>
<html>

<head>

    <title>Register</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="/css/login.css">

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
                <div class="input-password">
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required>

                    <span class="toggle-password" onclick="togglePassword('password', this)">
                        <!-- Eye Open -->
                        <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        <!-- Eye Off -->
                        <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M3 3l18 18" />
                            <path stroke-width="2" d="M10.5 10.5a3 3 0 004.243 4.243" />
                            <path stroke-width="2" d="M9.88 5.09A9.77 9.77 0 0112 4.5c6 0 10.5 7.5 10.5 7.5a16.72 16.72 0 01-3.06 3.93M6.53 6.53A16.72 16.72 0 001.5 12s4.5 7.5 10.5 7.5a9.77 9.77 0 005.12-1.53" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label>KonfirmasiPassword</label>
                <div class="input-password">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required>

                    <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                        <!-- Eye Open -->
                        <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        <!-- Eye Off -->
                        <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M3 3l18 18" />
                            <path stroke-width="2" d="M10.5 10.5a3 3 0 004.243 4.243" />
                            <path stroke-width="2" d="M9.88 5.09A9.77 9.77 0 0112 4.5c6 0 10.5 7.5 10.5 7.5a16.72 16.72 0 01-3.06 3.93M6.53 6.53A16.72 16.72 0 001.5 12s4.5 7.5 10.5 7.5a9.77 9.77 0 005.12-1.53" />
                        </svg>
                    </span>
                </div>
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
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                el.classList.add("active");
            } else {
                input.type = "password";
                el.classList.remove("active");
            }
        }
    </script>
</body>

</html>

</html>
