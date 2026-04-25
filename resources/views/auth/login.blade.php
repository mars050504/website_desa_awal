<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="/css/login.css">

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
