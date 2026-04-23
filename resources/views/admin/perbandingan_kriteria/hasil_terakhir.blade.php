@extends('layouts.admin')

@section('title', 'Bobot Kriteria Terakhir')

@section('content')

<div class="page-header">
    <h2>Bobot Kriteria Terakhir</h2>
    <p>Hasil bobot yang terakhir disimpan ke database</p>
</div>

<div class="table-card modern-card">

    <div class="card-header">
        <h4>Bobot Prioritas (Wi)</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="80">Kode</th>
                    <th>Nama Kriteria</th>
                    <th width="150">Bobot</th>
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
                        Belum ada bobot tersimpan
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection