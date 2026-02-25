@extends('layouts.warga')

@section('content')

<div class="container-warga">
    <h2 class="section-title">Berita Desa</h2>

    <div class="berita-grid">
        @forelse($berita as $b)
        <a href="/berita/{{ $b->id }}" class="berita-card">
            @if($b->gambar)
                <img src="{{ asset('storage/'.$b->gambar) }}" alt="gambar berita">
            @endif

            <div class="berita-content">
                <h4>{{ $b->judul }}</h4>
                <p class="berita-date">
                    {{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}
                </p>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 100) }}</p>
            </div>
        </a>
        @empty
            <p>Belum ada berita desa.</p>
        @endforelse
    </div>
</div>

@endsection
