@extends('layouts.admin')

@section('title', 'Pengaturan Admin')

@section('content')

<div class="admin-card">

    {{-- HEADER --}}
    <div class="admin-header">
        <h2 class="page-title">Pengaturan Admin</h2>

        <a href="/setting/perangkat-desa" class="btn-primary">
            Kelola Perangkat Desa
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="setting-grid">

        {{-- ================= KIRI: BERITA ================= --}}
        <div class="setting-box">

            <h3>Tambah Berita</h3>

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

                    <td>
                        <a href="/setting/berita/{{ $b->id }}/edit" class="btn-primary btn-sm">
                            Edit
                        </a>

                        <form action="/setting/berita/{{ $b->id }}/delete" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn-danger btn-sm"
                                onclick="return confirm('Hapus berita ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>


        {{-- ================= KANAN: PASSWORD ================= --}}
        <div class="setting-box">

            <h3>Ubah Password Admin</h3>

            <form method="POST" action="/setting/update-password" class="form-admin">
                @csrf

                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="old_password" required>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="new_password_confirmation" required>
                </div>

                <button class="btn-primary">Update Password</button>
            </form>

        </div>

    </div>

</div>

@endsection