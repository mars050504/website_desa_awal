@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h2>Manajemen Kriteria (AHP)</h2>
    <p>Pengelolaan kriteria dan bobot prioritas</p>
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
        <h4>Tambah Kriteria</h4>
    </div>

    <form method="POST" action="/kriteria" class="form-modern">
        @csrf

        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" placeholder="Contoh: C1" required>
        </div>

        <div class="form-group">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" placeholder="Masukkan nama kriteria" required>
        </div>

        <div class="form-group">
            <label>Bobot (Wi)</label>
            <input type="number" step="0.0001" name="bobot" placeholder="0.0000" required>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Kriteria
            </button>
        </div>
    </form>

    <hr class="divider">

    {{-- ================= TABEL ================= --}}
    <div class="card-header">
        <h4>Daftar Kriteria</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="80">Kode</th>
                    <th>Nama Kriteria</th>
                    <th width="150">Bobot (Wi)</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($kriteria as $k)
                <tr>
                    <td class="fw-semibold">{{ $k->kode }}</td>

                    <td>
                        <form method="POST" action="/kriteria/{{ $k->id }}/update" class="form-table-modern">
                            @csrf
                            <input type="text" name="nama_kriteria" value="{{ $k->nama_kriteria }}">
                    </td>

                    <td>
                            <input type="number" step="0.0001" name="bobot" value="{{ $k->bobot }}">
                    </td>

                    <td>
                            <div class="action-buttons">
                                <button class="btn-edit">
                                    <i class="fas fa-save"></i>
                                </button>
                        </form>

                        <form method="POST" action="/kriteria/{{ $k->id }}/delete">
                            @csrf
                            <button class="btn-danger"
                                onclick="return confirm('Hapus kriteria ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                            </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        Belum ada data kriteria
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection