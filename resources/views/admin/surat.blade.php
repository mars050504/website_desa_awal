@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h2>Kelola Surat</h2>
    <p>Manajemen pengajuan surat warga</p>
</div>

<div class="table-card modern-card">

    <div class="card-header">
        <h4>Daftar Pengajuan Surat</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama Warga</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surats as $s)
                <tr>
                    <td class="fw-semibold">{{ $s->nama }}</td>
                    <td>{{ $s->jenis }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                    <td>
                        @if($s->status == 'Selesai')
                        <span class="badge-success">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>

                        @elseif($s->status == 'Ditolak')
                        <span class="badge-danger">
                            <i class="fas fa-times-circle"></i> Ditolak
                        </span>

                        @else
                        <span class="badge-warning">
                            <i class="fas fa-clock"></i> Diproses
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ url('/kelola-surat/'.$s->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i>
                            </a>

                            <form action="{{ url('/kelola-surat/'.$s->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus surat ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        Belum ada data surat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection