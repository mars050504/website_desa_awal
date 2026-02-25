@extends('layouts.admin')

@section('title', 'Prioritas Surat')

@section('content')

<div class="page-header">
    <h2>Prioritas Surat Warga (AHP)</h2>
    <p>Hasil perhitungan sistem pendukung keputusan</p>
</div>

<div class="table-card modern-card">

    <div class="card-header">
        <h4>Ranking Prioritas</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="90">Ranking</th>
                    <th>Nama Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal</th>
                    <th>Nilai</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasil as $h)
                <tr>
                    <td>
                        <span class="badge-rank default">
                            {{ $h['ranking'] }}
                        </span>
                    </td>

                    <td>{{ $h['surat']->nama }}</td>
                    <td>{{ $h['surat']->jenis }}</td>
                    <td>{{ \Carbon\Carbon::parse($h['surat']->tanggal)->format('d M Y') }}</td>

                    <td>
                        <span class="nilai-prioritas">
                            {{ number_format($h['nilai'], 4) }}
                        </span>
                    </td>

                    <td>
                        <div class="action-buttons">
                            <a href="{{ url('/kelola-surat/'.$h['surat']->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i>
                            </a>

                            <form action="{{ url('/kelola-surat/'.$h['surat']->id) }}" method="POST">
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
                    <td colspan="6" class="empty-state">
                        Belum ada data surat untuk dihitung
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection