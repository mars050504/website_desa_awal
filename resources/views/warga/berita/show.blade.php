@extends('layouts.warga')

@section('content')

<div class="container-warga">
    <div class="card-warga berita-detail">
        <h2>{{ $berita->judul }}</h2>
        <p class="berita-date">
            Dipublikasikan {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
        </p>

        @if($berita->gambar)
            <img src="{{ asset('storage/'.$berita->gambar) }}" class="berita-detail-img">
        @endif

        <div class="berita-text">
            {!! nl2br(e($berita->isi)) !!}
        </div>

        <a href="/berita" class="btn-primary mt-3">← Kembali ke Berita</a>
    </div>
</div>

@endsection
