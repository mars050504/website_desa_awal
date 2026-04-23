@extends('layouts.admin')

@section('title', 'Berita Desa')

@section('content')

<div class="admin-card">

    <div class="admin-header">
        <h2 class="page-title">
            <i class="fas fa-newspaper"></i> Kelola Berita Desa
        </h2>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM TAMBAH --}}
    <div class="setting-box">

        <h3><i class="fas fa-plus-circle"></i> Tambah Berita</h3>

        <form method="POST" action="/setting/berita" enctype="multipart/form-data" class="form-admin">
            @csrf

            <div class="form-group">
                <label>Judul Berita</label>
                <input type="text" name="judul" required>
            </div>

            <div class="form-group">
                <label>Isi Berita</label>
                <textarea name="isi" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label>Gambar (Opsional)</label>
                <input type="file" name="gambar">
            </div>

            <button class="btn-primary">
                <i class="fas fa-save"></i> Simpan Berita
            </button>

        </form>

    </div>

    <hr class="divider">

    {{-- TABLE --}}
    <div class="setting-box">

        <h3><i class="fas fa-list"></i> Daftar Berita</h3>

        <table class="table-admin">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($berita as $b)
            <tr>

                <td>
                    @if($b->gambar)
                        <img src="{{ $b->gambar }}" width="70" style="border-radius:8px;">
                    @else
                        -
                    @endif
                </td>

                <td>{{ $b->judul }}</td>

                <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}</td>

                <td style="display:flex; gap:6px;">

                    <a href="/setting/berita/{{ $b->id }}/edit" class="btn-edit btn-icon">
                        <i class="fas fa-pen"></i>
                    </a>

                    <form action="/setting/berita/{{ $b->id }}/delete" method="POST">
                        @csrf
                        <button class="btn-danger btn-icon"
                            onclick="return confirm('Hapus berita ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                </td>

            </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection