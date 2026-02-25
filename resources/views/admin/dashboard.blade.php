@extends('layouts.admin')

@section('content')


<div class="stats-grid">

    <div class="stat-card primary">
        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $surat->count() }}</h3>
            <span>Total Pengajuan</span>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $surat->whereNotNull('dok_ktp')->count() }}</h3>
            <span>Permohonan Masuk</span>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>0</h3>
            <span>Surat Selesai</span>
        </div>
    </div>

</div>

<div class="table-card modern-card">
    <div class="card-header">
        <h4>Daftar Permohonan</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal</th>
                    <th>Kelengkapan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surat as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="nama">{{ $s->nama }}</td>
                    <td>{{ $s->jenis }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                    <td>
                        <span class="badge-success">
                            Dokumen Dicek
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">
                        Belum ada pengajuan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection