<!DOCTYPE html>
<html>
<head>
    <title>Website Desa</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    >
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="/dashboard">Website Desa</a>

        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">Dashboard</a>
            </li>

            @auth
                {{-- MENU ADMIN --}}
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="/ahp">AHP</a>
                        <a class="nav-link" href="/kriteria">Kriteria</a>
                        <a class="nav-link" href="/alternatif">Alternatif</a>
                        <a class="nav-link" href="/perbandingan-kriteria">Perbandingan Kriteria</a>
                    </li>
                @endif

                {{-- MENU WARGA --}}
                @if(auth()->user()->role === 'warga')
                    <li class="nav-item">
                        <a class="nav-link" href="/ajukan-surat">Ajukan Surat</a>
                    </li>
                @endif
            @endauth
        </ul>

        @auth
            <span class="navbar-text text-white me-3">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        @endauth

    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
