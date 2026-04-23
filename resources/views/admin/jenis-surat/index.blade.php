@extends('layouts.admin')

@section('title', 'Jenis Surat')

@section('content')

<div class="page-header">
    <h2>Manajemen Jenis Surat</h2>
    <p>Pengaturan kategori surat dan tingkat urgensi</p>
</div>

@if(session('success'))
<div class="alert-modern">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="table-card modern-card">

    {{-- ================= FORM TAMBAH ================= --}}
    <div class="card-header">
        <h4>Tambah Jenis Surat</h4>
    </div>

    <form method="POST" action="/jenis-surat" class="form-modern">
        @csrf

        <div class="form-group">
            <label>Nama Jenis Surat</label>
            <input type="text" name="nama_jenis" placeholder="Masukkan nama jenis surat" required>
        </div>

        <div class="form-group">
            <label>Urgensi</label>
            <select name="urgensi" class="select-modern" required>
                <option value="Mendesak">Mendesak</option>
                <option value="Tergolong Menengah">Tergolong Menengah</option>
                <option value="Tidak Mendesak">Tidak Mendesak</option>
            </select>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Jenis
            </button>
        </div>
    </form>

    <hr class="divider">

    {{-- ================= TABEL ================= --}}
    <div class="card-header">
        <h4>Daftar Jenis Surat</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="280">Nama Jenis Surat</th>
                    <th width="180">Urgensi</th>
                    <th width="120">Nilai</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenis as $j)
                <tr>
                    <form method="POST" action="/jenis-surat/{{ $j->id }}/update" class="form-table-modern">
                        @csrf

                        <td style="min-width:300px; white-space:normal;">
                            <input type="text"
                                name="nama_jenis"
                                value="{{ $j->nama_jenis }}"
                                style="width:100%; min-width:250px;">
                        </td>

                        <td>
                            <select name="urgensi" class="select-modern">
                                <option value="Mendesak" {{ $j->urgensi=='Mendesak'?'selected':'' }}>Mendesak</option>
                                <option value="Tergolong Menengah" {{ $j->urgensi=='Tergolong Menengah'?'selected':'' }}>Tergolong Menengah</option>
                                <option value="Tidak Mendesak" {{ $j->urgensi=='Tidak Mendesak'?'selected':'' }}>Tidak Mendesak</option>
                            </select>
                        </td>

                        <td>
                            <span class="badge-modern">
                                {{ $j->nilai }}
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">
                                    <i class="fas fa-save"></i>
                                </button>
                    </form>

                    <form method="POST" action="/jenis-surat/{{ $j->id }}/delete">
                        @csrf
                        <button class="btn-danger"
                            onclick="return confirm('Hapus jenis surat ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
    </div>
    </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="empty-state">
            Belum ada jenis surat
        </td>
    </tr>
    @endforelse
    </tbody>
    </table>
</div>

</div>

@endsection