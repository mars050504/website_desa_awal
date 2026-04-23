@extends('layouts.warga')

@section('content')

<div class="container-warga berita-detail-page">

    <div class="berita-detail-card">

        <h1 class="berita-title">{{ $berita->judul }}</h1>

        <p class="berita-date">
            <i class="fa-solid fa-calendar-days"></i>
            Dipublikasikan {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
        </p>

        @if($berita->gambar)
            <div class="berita-image-wrapper">
                <img src="{{ $berita->gambar }}" class="berita-detail-img">
            </div>
        @endif

        <div class="berita-text">
            {!! nl2br(e($berita->isi)) !!}
        </div>

        <a href="/berita" class="btn-back">
            Kembali ke Berita
        </a>

    </div>

</div>

@endsection