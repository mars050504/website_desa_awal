@extends('layouts.admin')

@section('content')
<div class="admin-card">
    <h2 class="page-title">Pengaturan Berita Desa</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

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

        <button class="btn-primary">Simpan Berita</button>
    </form>

    <hr class="divider">

    <h4>Daftar Berita</h4>
    <table class="table-admin">
    <tr>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    @foreach($berita as $b)
    <tr>
        <td>{{ $b->judul }}</td>
        <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}</td>
        <td>
            <a href="/setting/berita/{{ $b->id }}/edit" class="btn-warning btn-edit">Edit</a>

            <form action="/setting/berita/{{ $b->id }}/delete" method="POST" style="display:inline;">
                @csrf
                <button class="btn-danger btn-sm" onclick="return confirm('Hapus berita ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</div>
@endsection
