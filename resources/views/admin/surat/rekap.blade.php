@extends('layouts.admin')

@section('title', 'Rekap Surat')

@section('content')

<div class="page-header">
    <h2>Rekapitulasi Surat</h2>
    <p>Data pengajuan berdasarkan bulan</p>
</div>

<div class="admin-card">

    <div class="rekap-list">

        @foreach($rekapBulanan as $r)

        @php
            $bulanFormat = \Carbon\Carbon::createFromFormat('Y-m', $r->bulan);
        @endphp

        <a href="/rekap-surat?bulan={{ $r->bulan }}"
           class="rekap-item {{ request('bulan') == $r->bulan ? 'active' : '' }}">

            {{ $bulanFormat->translatedFormat('F Y') }}
            ({{ $r->total }})

        </a>

        @endforeach

    </div>

</div>

@if(request('bulan'))
<div style="margin-bottom: 15px;">
    <a href="/rekap-surat/export?bulan={{ request('bulan') }}"
       class="btn-primary">
        Export Excel
    </a>
</div>
<div class="admin-card mt-3">

    <h4>
        Data Bulan 
        {{ \Carbon\Carbon::createFromFormat('Y-m', request('bulan'))->translatedFormat('F Y') }}
    </h4>

    <table class="table-modern">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($surats as $s)
            <tr>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->nama_jenis }}</td>
                <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                <td>{{ $s->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data</td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>

@endif

@endsection