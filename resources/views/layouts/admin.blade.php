<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="admin-wrapper">

        <div class="overlay"></div>

        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-landmark"></i>
                <span>Admin Desa Bloro</span>
            </div>

            <ul class="sidebar-menu">

                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->is('warga') ? 'active' : '' }}">
                    <a href="{{ url('/warga') }}">
                        <i class="fas fa-users"></i>
                        <span>Warga</span>
                    </a>
                </li>

                <li class="{{ request()->is('kelola-surat') ? 'active' : '' }}">
                    <a href="{{ url('/kelola-surat') }}">
                        <i class="fas fa-envelope-open-text"></i>
                        <span>Kelola Surat</span>
                    </a>
                </li>

                <li class="has-submenu {{ request()->is('kriteria*','alternatif*','perbandingan-kriteria*','ahp*','jenis-surat*') ? 'open' : '' }}">
                    <a href="#" class="submenu-toggle">
                        <i class="fas fa-database"></i>
                        <span>Data</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </a>

                    <ul class="submenu">
                        <li class="{{ request()->is('kriteria') ? 'active' : '' }}">
                            <a href="{{ url('/kriteria') }}">
                                <i class="fas fa-list-check"></i>
                                Kriteria
                            </a>
                        </li>

                        <li class="{{ request()->is('alternatif') ? 'active' : '' }}">
                            <a href="{{ url('/alternatif') }}">
                                <i class="fas fa-layer-group"></i>
                                Alternatif
                            </a>
                        </li>

                        <li class="{{ request()->is('perbandingan-kriteria') ? 'active' : '' }}">
                            <a href="{{ url('/perbandingan-kriteria') }}">
                                <i class="fas fa-scale-balanced"></i>
                                Perbandingan
                            </a>
                        </li>

                        <li class="{{ request()->is('ahp/matriks-alternatif') ? 'active' : '' }}">
                            <a href="{{ url('/ahp/matriks-alternatif') }}">
                                <i class="fas fa-table"></i>
                                Matriks Alternatif
                            </a>
                        </li>

                        <li class="{{ request()->is('ahp/prioritas-global') ? 'active' : '' }}">
                            <a href="{{ url('/ahp/prioritas-global') }}">
                                <i class="fas fa-chart-line"></i>
                                Prioritas Global
                            </a>
                        </li>

                        <li class="{{ request()->is('ahp/prioritas') ? 'active' : '' }}">
                            <a href="{{ url('/ahp/prioritas') }}">
                                <i class="fas fa-ranking-star"></i>
                                Prioritas (AHP)
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- 🔥 SETTING DROPDOWN --}}
                <li class="has-submenu {{ request()->is('setting*') ? 'open' : '' }}">
                    <a href="#" class="submenu-toggle">
                        <i class="fas fa-cog"></i>
                        <span>Setting</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </a>

                    <ul class="submenu">

                        <li class="{{ request()->is('setting/berita') ? 'active' : '' }}">
                            <a href="{{ url('/setting/berita') }}">
                                <i class="fas fa-newspaper"></i>
                                Berita Desa
                            </a>
                        </li>

                        <li class="{{ request()->is('setting/password') ? 'active' : '' }}">
                            <a href="{{ url('/setting/password') }}">
                                <i class="fas fa-key"></i>
                                Ubah Password
                            </a>
                        </li>

                        <li class="{{ request()->is('setting/perangkat-desa') ? 'active' : '' }}">
                            <a href="{{ url('/setting/perangkat-desa') }}">
                                <i class="fas fa-sitemap"></i>
                                Perangkat Desa
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>

            <div class="sidebar-logout">
                <a href="/logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
                <form id="logout-form" action="/logout" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </aside>

        <div class="main-content">

            <div class="topbar">
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <h2>@yield('title', 'Dashboard')</h2>

                <div class="user-info">
                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                    <span class="username">{{ auth()->user()->name }}</span>
                </div>
            </div>

            <div class="content-area">
                @yield('content')
            </div>

        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const toggles = document.querySelectorAll(".submenu-toggle");
            const sidebar = document.querySelector(".sidebar");
            const overlay = document.querySelector(".overlay");
            const menuToggle = document.querySelector(".menu-toggle");

            toggles.forEach(toggle => {
                toggle.addEventListener("click", function(e) {
                    e.preventDefault();
                    this.closest(".has-submenu").classList.toggle("open");
                });
            });

            menuToggle.addEventListener("click", function() {
                sidebar.classList.toggle("active");
                overlay.classList.toggle("show");
            });

            overlay.addEventListener("click", function() {
                sidebar.classList.remove("active");
                overlay.classList.remove("show");
            });

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
