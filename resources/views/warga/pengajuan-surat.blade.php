@extends('layouts.warga')

@section('content')

<div class="container-warga">
    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-error">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-warga">

        <div class="card-header-warga">
            <div>
                <h3>Pengajuan Surat</h3>
                <p>Halo, <b>{{ auth()->user()->name }}</b></p>
            </div>

            <a href="/ajukan-surat" class="btn-primary">
                + Ajukan Surat Baru
            </a>
        </div>

        @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
        @endif

        <h5 class="section-title">Riwayat Pengajuan Surat</h5>

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
                    @forelse($surat as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->jenis }}</td>
                        <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="doc-status {{ $s->dok_ktp ? 'ok' : 'no' }}">KTP</span>
                            <span class="doc-status {{ $s->dok_kk ? 'ok' : 'no' }}">KK</span>
                            <span class="doc-status {{ $s->dok_pengantar ? 'ok' : 'no' }}">Pengantar</span>
                        </td>
                        <td>
                            @if(!$s->dok_ktp || !$s->dok_kk || !$s->dok_pengantar)
                            <a href="/surat/{{ $s->id }}/edit" class="btn-warning btn-sm">
                                Lengkapi
                            </a>
                            @else
                            <span class="badge-success">Lengkap</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada pengajuan surat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection