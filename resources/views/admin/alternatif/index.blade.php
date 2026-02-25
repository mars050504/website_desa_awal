@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h2>Manajemen Alternatif</h2>
    <p>Pengelolaan alternatif dalam sistem AHP</p>
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
        <h4>Tambah Alternatif</h4>
    </div>

    <form method="POST" action="/alternatif" class="form-modern">
        @csrf

        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" placeholder="Contoh: A1" required>
        </div>

        <div class="form-group">
            <label>Nama Alternatif</label>
            <input type="text" name="nama_alternatif" placeholder="Masukkan nama alternatif" required>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="keterangan" placeholder="Opsional">
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Alternatif
            </button>
        </div>
    </form>

    <hr class="divider">

    {{-- ================= TABEL ================= --}}
    <div class="card-header">
        <h4>Daftar Alternatif</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="80">Kode</th>
                    <th>Nama Alternatif</th>
                    <th>Keterangan</th>
                    <th width="120">Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($alternatif as $a)
                <tr>
                    <td class="fw-semibold">{{ $a->kode }}</td>

                    <td>
                        <form method="POST" action="/alternatif/{{ $a->id }}/update" class="form-table-modern">
                            @csrf
                            <input type="text" name="nama_alternatif" value="{{ $a->nama_alternatif }}">
                    </td>

                    <td>
                            <input type="text" name="keterangan" value="{{ $a->keterangan }}">
                    </td>

                    <td>
                            <select name="aktif" class="select-modern">
                                <option value="1" {{ $a->aktif ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$a->aktif ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                    </td>

                    <td>
                            <div class="action-buttons">
                                <button class="btn-edit">
                                    <i class="fas fa-save"></i>
                                </button>
                        </form>

                        <form method="POST" action="/alternatif/{{ $a->id }}/delete">
                            @csrf
                            <button class="btn-danger"
                                onclick="return confirm('Hapus alternatif ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                            </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        Belum ada data alternatif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection