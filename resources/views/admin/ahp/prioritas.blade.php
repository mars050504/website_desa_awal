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
                    <th width="70">Ranking</th>
                    <th>Nama Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal</th>
                    <th>Status Dokumen</th>
                    <th>Nilai</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasil as $h)

                @php
                $lengkap = (
                $h['surat']->dok_ktp &&
                $h['surat']->dok_kk &&
                $h['surat']->dok_pengantar
                );
                @endphp

                <tr class="{{ $lengkap ? 'row-lengkap' : 'row-tidak-lengkap' }}">

                    <td>
                        <span class="badge-rank default">
                            {{ $h['ranking'] }}
                        </span>
                    </td>

                    <td>{{ $h['surat']->nama }}</td>
                    <td>{{ $h['surat']->nama_jenis }}</td>

                    <td>{{ \Carbon\Carbon::parse($h['surat']->tanggal)->format('d M Y') }}</td>

                    <td>
                        <div class="status-containers">

                            {{-- Status Dokumen --}}
                            @if($lengkap)
                            <span class="badge-success">Lengkap</span>
                            @else
                            <span class="badge-warning">Tidak Lengkap</span>
                            @endif

                            {{-- Status Proses --}}
                            @if($h['surat']->status == 'Diproses')
                            <span class="badge-warning">Diproses</span>

                            @elseif($h['surat']->status == 'Selesai')
                            <span class="badge-success">Selesai</span>

                            @elseif($h['surat']->status == 'Ditolak')
                            <span class="badge-danger">Ditolak</span>
                            @endif

                        </div>
                    </td>

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
                    <td colspan="7" class="empty-state">
                        Belum ada data surat untuk dihitung
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection