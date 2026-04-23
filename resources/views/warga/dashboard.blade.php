@extends('layouts.warga')

@section('content')

@if(session('benchmark'))
<div id="benchmarkAlert" class="benchmark-alert">
    <strong><i class="fas fa-clock"></i> Benchmark Login</strong><br>

    Bcrypt: {{ number_format(session('benchmark.bcrypt'), 6) }} s <br>
    MD5: {{ number_format(session('benchmark.md5'), 6) }} s <br>
    SHA1: {{ number_format(session('benchmark.sha1'), 6) }} s
</div>

<script>
    setTimeout(function() {
        const alert = document.getElementById('benchmarkAlert');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>
@endif


@php
    $file = null;
    $path = public_path('images/wallpaper/active.txt');

    if (file_exists($path)) {
        $file = trim(file_get_contents($path));
    }
@endphp


<!-- HERO SECTION -->
<section class="hero"
    style="background-image:
        linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)),
        url('{{ $file ? asset('images/wallpaper/'.$file) : asset('images/default.jpg') }}');">

    <div class="hero-content">

        <h1>Selamat Datang di Desa Bloro</h1>
        <p>Website Desa Asri, Sejuk, Damai dan Penuh Kebahagiaan</p>

        @auth
        <a href="/ajukan-surat" class="btn-hero">
            <i class="fas fa-pen-to-square"></i> Ajukan Surat
        </a>
        @else
        <a href="/login" class="btn-hero">
            <i class="fas fa-right-to-bracket"></i> Login Untuk Fitur Lebih Lengkap
        </a>
        @endauth

    </div>
</section>


<!-- FEATURES -->
<section class="features">

    <div class="feature-box">
        <i class="fas fa-file-alt"></i>
        <h3>Layanan Surat Online</h3>
        <p>Ajukan surat dengan mudah tanpa harus ke kantor desa.</p>
    </div>

    <div class="feature-box">
        <i class="fas fa-clock"></i>
        <h3>Proses Cepat</h3>
        <p>Pelayanan efisien dan transparan.</p>
    </div>

    <div class="feature-box">
        <i class="fas fa-database"></i>
        <h3>Data Terintegrasi</h3>
        <p>Data aman dan terkelola dengan baik.</p>
    </div>

</section>


<!-- ================= BERITA ================= -->
<section class="container-warga">

    <div class="section-header">
        <h3><i class="fas fa-newspaper"></i> Berita Terbaru</h3>
        <a href="/berita" class="lihat-semua">Lihat Semua</a>
    </div>

    <div class="berita-grid">

        @forelse($berita as $b)
        <div class="berita-card">

            <div class="berita-image">
                @if($b->gambar)
                    <img src="{{ $b->gambar }}" alt="berita">
                @else
                    <img src="https://via.placeholder.com/400x200?text=No+Image" alt="no image">
                @endif
            </div>

            <div class="berita-content">
                <div class="berita-date">
                    {{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}
                </div>

                <h4>{{ $b->judul }}</h4>

                <p>
                    {{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 80) }}
                </p>

                <a href="/berita/{{ $b->id }}" class="btn-primary">
                    <i class="fas fa-eye"></i> Baca
                </a>
            </div>

        </div>
        @empty
            <p class="empty-text">Belum ada berita.</p>
        @endforelse

    </div>

</section>


<!-- ================= MAP ================= -->
<section class="container-warga">

    <div class="section-header">
        <h3><i class="fas fa-map-marker-alt"></i> Lokasi Desa</h3>
    </div>

    <div class="map-box">
        <iframe
            src="https://www.google.com/maps?q=Desa+Bloro&output=embed"
            allowfullscreen>
        </iframe>
    </div>

</section>

@endsection