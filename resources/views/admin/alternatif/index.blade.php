@extends('layouts.admin')

@section('title', 'Alternatif (Jenis Surat)')

@section('content')

<div class="page-header">
    <h2>Alternatif (Jenis Surat)</h2>
    <p>Pengaturan nilai dasar berdasarkan tingkat kepentingan surat</p>
</div>

@if(session('success'))
    <div class="alert-modern">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="table-card modern-card">

    <div class="card-header">
        <h4>Daftar Jenis Surat</h4>
        <span class="info-badge">Total: {{ count($jenisSurat) }}</span>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Jenis Surat</th>
                    <th>Urgensi</th>
                    <th>Nilai</th>
                    <th width="140">Update</th>
                </tr>
            </thead>

            <tbody>
            @forelse($jenisSurat as $j)
                <tr>

                    {{-- ID --}}
                    <td class="fw-semibold">{{ $j->id }}</td>

                    {{-- Nama --}}
                    <td>
                        <div style="display:flex; flex-direction:column;">
                            <strong>{{ $j->nama_jenis }}</strong>
                            <small style="color:#888;">Slug: {{ $j->slug }}</small>
                        </div>
                    </td>

                    {{-- Urgensi --}}
                    <td>
                        @if($j->urgensi == 'Mendesak')
                            <span class="badge-danger">
                                <i class="fas fa-bolt"></i> Mendesak
                            </span>
                        @elseif($j->urgensi == 'Tergolong Menengah')
                            <span class="badge-warning">
                                <i class="fas fa-exclamation"></i> Menengah
                            </span>
                        @else
                            <span class="badge-success">
                                <i class="fas fa-check"></i> Tidak Mendesak
                            </span>
                        @endif
                    </td>

                    {{-- NILAI (EDITABLE) --}}
                    <td>
                        <form method="POST" action="/jenis-surat/{{ $j->id }}/update-nilai" style="display:flex; gap:10px;">
                            @csrf

                            <select name="nilai" class="select-modern">

                                <option value="1" {{ $j->nilai == 1 ? 'selected' : '' }}>
                                    1 - Tidak Mendesak
                                </option>

                                <option value="2" {{ $j->nilai == 2 ? 'selected' : '' }}>
                                    2 - Menengah
                                </option>

                                <option value="3" {{ $j->nilai == 3 ? 'selected' : '' }}>
                                    3 - Mendesak
                                </option>

                            </select>
                    </td>

                    {{-- BUTTON --}}
                    <td>
                            <button class="btn-edit">
                                <i class="fas fa-save"></i>
                            </button>
                        </form>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        Belum ada data jenis surat
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection