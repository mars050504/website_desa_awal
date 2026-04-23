@extends('layouts.admin')

@section('title', 'Prioritas Global')

@section('content')

<div class="page-header">
    <h2>Perhitungan Prioritas Global</h2>
    <p>Perhitungan dilakukan dengan mengalikan bobot kriteria dengan nilai alternatif</p>
</div>

<div class="table-card modern-card">

    <div class="card-header">
        <h4>Detail Perhitungan</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                    <th>v1</th>
                    <th>v2</th>
                    <th>v3</th>
                    <th>v4</th>
                    <th>Total (Pi)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr>
                    <td class="fw-semibold">{{ $h['nama'] }}</td>

                    <td>{{ $h['c1'] }}</td>
                    <td>{{ $h['c2'] }}</td>
                    <td>{{ $h['c3'] }}</td>
                    <td>{{ $h['c4'] }}</td>

                    <td>{{ number_format($h['v1'], 4) }}</td>
                    <td>{{ number_format($h['v2'], 4) }}</td>
                    <td>{{ number_format($h['v3'], 4) }}</td>
                    <td>{{ number_format($h['v4'], 4) }}</td>

                    <td>
                        <span class="nilai-prioritas">
                            {{ number_format($h['nilai'], 4) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- ================= RANKING ================= --}}
<div class="table-card modern-card mt-4">

    <div class="card-header">
        <h4>Ranking Alternatif</h4>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="80">Ranking</th>
                    <th>Alternatif</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr>
                    <td>
                        <span class="badge-rank">
                            {{ $h['ranking'] }}
                        </span>
                    </td>

                    <td class="fw-semibold">{{ $h['nama'] }}</td>

                    <td>
                        <span class="nilai-prioritas">
                            {{ number_format($h['nilai'], 4) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- ================= PENJELASAN ================= --}}
<div class="table-card modern-card mt-4">

    <div class="card-header">
        <h4>Penjelasan Perhitungan</h4>
    </div>

    <div style="padding:20px; line-height:1.8;">

        <p>
            Perhitungan prioritas global dilakukan dengan menggunakan rumus:
        </p>

        <p style="font-weight:bold;">
            Pi = (C1 × W1) + (C2 × W2) + (C3 × W3) + (C4 × W4)
        </p>

        <p>
            Dimana:
        </p>

        <ul>
            <li><b>C1</b> = Waktu Pengajuan</li>
            <li><b>C2</b> = Kelengkapan Dokumen</li>
            <li><b>C3</b> = Tingkat Urgensi</li>
            <li><b>C4</b> = Frekuensi Pengajuan</li>
        </ul>

        <p>
            Nilai v1, v2, v3, dan v4 merupakan hasil perkalian antara nilai kriteria dengan bobot masing-masing kriteria.
        </p>

    </div>

</div>

@endsection