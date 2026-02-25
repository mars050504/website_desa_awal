@extends('layouts.warga')

@section('title', 'Riwayat Surat')

@section('content')

<div class="container-warga">

    <div class="card-warga">
        <div class="card-header-warga">
            <h3><i class="fas fa-history"></i> Riwayat Pengajuan Surat</h3>
            <span class="card-subtitle">Daftar surat yang pernah diajukan</span>
        </div>

        @if($surat->isEmpty())
            <div class="empty-state">
                <i class="fas fa-folder-open" style="font-size:40px; margin-bottom:10px;"></i>
                <p>Belum ada riwayat pengajuan surat.</p>
            </div>
        @else

            <div class="table-responsive">
                <table class="table-warga">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal</th>
                            <th>Status Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surat as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $s->jenis }}</strong>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}
                            </td>

                            <td>
                                <div class="doc-status">
                                    <span class="{{ $s->dok_ktp ? 'badge-success' : 'badge-danger' }}">
                                        KTP
                                    </span>
                                    <span class="{{ $s->dok_kk ? 'badge-success' : 'badge-danger' }}">
                                        KK
                                    </span>
                                    <span class="{{ $s->dok_pengantar ? 'badge-success' : 'badge-danger' }}">
                                        Pengantar
                                    </span>
                                </div>
                            </td>

                            <td>
                                @if(!$s->dok_ktp || !$s->dok_kk || !$s->dok_pengantar)
                                    <a href="/surat/{{ $s->id }}/edit" class="btn-warning">
                                        <i class="fas fa-edit"></i> Lengkapi
                                    </a>
                                @else
                                    <span class="badge-success">
                                        <i class="fas fa-check"></i> Lengkap
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

</div>

@endsection