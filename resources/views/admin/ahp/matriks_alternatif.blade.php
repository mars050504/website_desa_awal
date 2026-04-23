@extends('layouts.admin')

@section('title', 'Matriks Alternatif')

@section('content')

<div class="page-header">
    <h2>Matriks Alternatif</h2>
    <p>Nilai alternatif dan hasil normalisasi</p>
</div>

{{-- ================= MATRKS AWAL ================= --}}
<div class="table-card modern-card">
    <div class="card-header">
        <h4>1. Matriks Alternatif (Nilai Awal)</h4>
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
                </tr>
            </thead>

            <tbody>
            @foreach($matrixAlternatif as $m)
                <tr>
                    <td>{{ $m['nama'] }}</td>
                    <td>{{ $m['C1'] }}</td>
                    <td>{{ $m['C2'] }}</td>
                    <td>{{ $m['C3'] }}</td>
                    <td>{{ $m['C4'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ================= NORMALISASI ================= --}}
<div class="table-card modern-card">
    <div class="card-header">
        <h4>2. Matriks Normalisasi</h4>
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
                </tr>
            </thead>

            <tbody>
            @foreach($matrixNormalisasi as $m)
                <tr>
                    <td>{{ $m['nama'] }}</td>
                    <td>{{ number_format($m['C1'], 2) }}</td>
                    <td>{{ number_format($m['C2'], 2) }}</td>
                    <td>{{ number_format($m['C3'], 2) }}</td>
                    <td>{{ number_format($m['C4'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection