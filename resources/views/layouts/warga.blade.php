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
    <link rel="stylesheet" href="/css/warga.css">

</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo desa Bloro">
            <span>Desa Bloro</span>
        </div>
        <div class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>

        <ul class="nav-menu">
            <li>
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ url('/berita') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> Berita
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="openBantuan()">
                    <i class="fas fa-circle-question"></i> Bantuan
                </a>
            </li>

            @auth
            <li>
                <a href="{{ url('/ajukan-surat') }}" class="{{ request()->is('ajukan-surat*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Pengajuan
                </a>
            </li>

            <li>
                <a href="{{ url('/riwayat-surat') }}" class="{{ request()->is('riwayat-surat*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Riwayat
                </a>
            </li>

            <li>
                <a href="{{ url('/struktur-desa') }}" class="{{ request()->is('struktur-desa*') ? 'active' : '' }}">
                    <i class="fas fa-sitemap"></i>
                    <span>Struktur Pemerintahan</span>
                </a>
            </li>
            @endauth
        </ul>

        <div class="nav-right">
            @auth
            <div class="user-dropdown">
                <div class="user-box">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>

                <div class="dropdown-menu">
                    <a href="{{ url('/profil') }}">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>

                    <a href="{{ url('/riwayat-surat') }}">
                        <i class="fas fa-history"></i> Riwayat
                    </a>

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ url('/login') }}" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            @endauth
        </div>

    </nav>

    <main>
        @yield('content')
    </main>

    <div id="modalBantuan" class="modal-bantuan">
        <div class="modal-content">

            <span class="close" onclick="closeBantuan()">&times;</span>

            <h3><i class="fas fa-book"></i> Bantuan Pengajuan Surat</h3>

            <div class="panduan-item">
                <h4><i class="fas fa-lock"></i> Akses Sistem</h4>
                <ul>
                    <li>Pengguna harus <b>login terlebih dahulu</b></li>
                    <li>Jika belum memiliki akun, silakan <b>daftar (register)</b></li>
                    <li>Gunakan data yang valid saat pendaftaran</li>
                </ul>
            </div>

            <div class="panduan-item">
                <h4><i class="fas fa-list-ol"></i> Langkah Pengajuan</h4>
                <ol>
                    <li>Login ke sistem</li>
                    <li>Pilih menu <b>Pengajuan Surat</b></li>
                    <li>Pilih jenis surat yang dibutuhkan</li>
                    <li>Isi data dengan lengkap dan benar</li>
                    <li>Upload dokumen yang diminta</li>
                    <li>Periksa kembali data</li>
                    <li>Klik tombol <b>Kirim</b></li>
                </ol>
            </div>

            <div class="panduan-item">
                <h4><i class="fas fa-file-alt"></i> Dokumen Umum</h4>
                <ul>
                    <li>Fotokopi / scan <b>KTP</b></li>
                    <li>Fotokopi / scan <b>Kartu Keluarga (KK)</b></li>
                    <li>Dokumen tambahan sesuai jenis surat</li>
                </ul>
            </div>

            <div class="panduan-item">
                <h4><i class="fas fa-folder-open"></i> Contoh Kebutuhan Surat</h4>
                <ul>
                    <li><b>Surat Domisili:</b> KTP, KK, alamat lengkap</li>
                    <li><b>Surat Keterangan Usaha (SKU):</b> KTP, KK, foto usaha, surat pengantar RT/RW</li>
                    <li><b>Surat Tidak Mampu (SKTM):</b> KTP, KK, surat pengantar RT/RW</li>
                    <li><b>Surat Kelahiran:</b> KTP orang tua, KK, surat keterangan lahir</li>
                    <li><b>Surat Kehilangan:</b> KTP, KK, surat pengantar kehilangan</li>
                    <li><b>Surat Kematian:</b> KTP almarhum, KK, surat keterangan kematian</li>
                    <li><b>Surat SKCK:</b> KTP, KK, surat pengantar RT/RW</li>
                    <li><b>Surat Tanah:</b> KTP, KK, <b>SPPT / PBB</b>, bukti kepemilikan tanah</li>
                </ul>
            </div>

            <div class="panduan-item">
                <h4><i class="fas fa-triangle-exclamation"></i> Catatan Penting</h4>
                <ul>
                    <li>Pastikan data diisi dengan benar dan lengkap</li>
                    <li>Dokumen harus jelas dan tidak buram</li>
                    <li>Kesalahan data dapat menyebabkan pengajuan ditolak</li>
                    <li>Periksa status pengajuan di menu <b>Riwayat</b></li>
                </ul>
            </div>

        </div>
    </div>
    <script>
        function toggleMenu() {
            document.querySelector('.nav-menu').classList.toggle('active');
        }

        function openBantuan() {
            document.getElementById('modalBantuan').style.display = 'block';
        }

        function closeBantuan() {
            document.getElementById('modalBantuan').style.display = 'none';
        }

        window.onclick = function(event) {
            let modal = document.getElementById('modalBantuan');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>
