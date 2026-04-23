@extends('layouts.admin')

@section('title', 'Kriteria Surat')

@section('content')

<div class="page-header">
    <h2>Kriteria AHP</h2>
    <p>Daftar kriteria yang digunakan dalam perhitungan prioritas surat</p>
</div>

@if(session('success'))
    <div class="alert-modern">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="table-card modern-card">

    {{-- ================= ACTION BUTTON ================= --}}
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4>Daftar Kriteria</h4>

        <div style="display:flex; gap:10px;">
            <a href="/perbandingan-kriteria" class="btn-primary">
                <i class="fas fa-calculator"></i> Hitung Bobot (AHP)
            </a>

            <a href="/perbandingan-kriteria/hasil-terakhir" class="btn-primary">
                <i class="fas fa-eye"></i> Lihat Bobot Terakhir
            </a>
        </div>
    </div>

    {{-- ================= TABEL ================= --}}
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="80">Kode</th>
                    <th>Nama Kriteria</th>
                    <th width="150">Bobot (Wi)</th>
                </tr>
            </thead>

            <tbody>
            @forelse($kriteria as $k)
                <tr>
                    <td class="fw-semibold">{{ $k->kode }}</td>

                    <td>
                        <strong>{{ $k->nama_kriteria }}</strong>
                    </td>

                    <td>
                        <span class="nilai-prioritas">
                            {{ number_format($k->bobot ?? 0, 4) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="empty-state">
                        Data kriteria belum tersedia
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection