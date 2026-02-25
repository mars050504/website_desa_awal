@extends('layouts.warga')

@section('content')

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Selamat Datang di Desa Bloro</h1>
        <p>Website Desa Asri, Sejuk, Damai dan Penuh Kebahagiaan</p>

        @auth
            <a href="/pengajuan-surat" class="btn-hero">Ajukan Surat →</a>
        @else
            <a href="/login" class="btn-hero">Login untuk Ajukan Surat →</a>
        @endauth
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features">
    <div class="feature-box">
        <i class="fas fa-file-alt"></i>
        <h3>Layanan Surat Online</h3>
        <p>Ajukan surat dengan mudah dan cepat tanpa harus datang ke kantor desa.</p>
    </div>

    <div class="feature-box">
        <i class="fas fa-clock"></i>
        <h3>Proses Cepat</h3>
        <p>Pelayanan efisien dan transparan dengan sistem terintegrasi.</p>
    </div>

    <div class="feature-box">
        <i class="fas fa-users"></i>
        <h3>Data Warga Terintegrasi</h3>
        <p>Data aman dan terkelola dengan baik untuk kemudahan pelayanan.</p>
    </div>
</section>

@endsection