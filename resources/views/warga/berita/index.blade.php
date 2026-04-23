@extends('layouts.warga')

@section('content')

<div class="container-warga berita-page">

    <h2 class="section-title">Berita Desa</h2>

    <div class="berita-grid">
        @forelse($berita as $b)

        <a href="/berita/{{ $b->id }}" class="berita-card">

            <div class="berita-image">
                @if($b->gambar)
                    <img src="{{ $b->gambar }}" alt="gambar berita">
                @else
                    <div class="no-image">Tidak ada gambar</div>
                @endif
            </div>

            <div class="berita-content">
                <p class="berita-date">
                    {{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}
                </p>

                <h4>{{ $b->judul }}</h4>

                <p class="berita-desc">
                    {{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 100) }}
                </p>

                <span class="read-more">
                    Baca Selengkapnya 
                </span>
            </div>

        </a>

        @empty
            <p class="empty-text">Belum ada berita desa.</p>
        @endforelse
    </div>

</div>

@endsection