@extends('layouts.admin')

@section('content')
<div class="admin-card">
    <h2 class="page-title">Edit Berita</h2>

    <form method="POST" action="/setting/berita/{{ $berita->id }}/update" enctype="multipart/form-data" class="form-admin">
        @csrf

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $berita->judul }}" required>
        </div>

        <div class="form-group">
            <label>Isi</label>
            <textarea name="isi" rows="6" required>{{ $berita->isi }}</textarea>
        </div>

        {{-- PREVIEW GAMBAR --}}
        @if($berita->gambar)
            <div class="form-group">
                <label>Gambar Saat Ini</label><br>
                <img src="{{ $berita->gambar }}" width="200" style="border-radius:10px;">
            </div>
        @endif

        <div class="form-group">
            <label>Gambar Baru (opsional)</label>
            <input type="file" name="gambar">
        </div>

        <button class="btn-primary">Update Berita</button>
    </form>
</div>
@endsection