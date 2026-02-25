<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Desa Bloro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/warga.css') }}">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar">
    <div class="logo">
        <i class="fas fa-landmark"></i> Desa Bloro
    </div>

    <ul class="nav-menu">
        <li><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ url('/berita') }}">Berita</a></li>

        @auth
            <li><a href="{{ url('/ajukan-surat') }}">Pengajuan Surat</a></li>
            <li><a href="{{ url('/riwayat-surat') }}">Riwayat Surat</a></li>
        @endauth
    </ul>

    <div class="nav-right">
        @auth
            <span class="user-name">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
            </span>

            <form action="{{ url('/logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        @else
            <a href="{{ url('/login') }}" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        @endauth
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<main>
    @yield('content')
</main>

</body>
</html>