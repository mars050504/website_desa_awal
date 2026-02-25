@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h2>Hasil Perhitungan AHP – Kriteria</h2>
    <p>Proses perhitungan bobot menggunakan metode Analytical Hierarchy Process</p>
</div>

<div class="table-card modern-card">

    {{-- ================= 1. MATRIKS PERBANDINGAN ================= --}}
    <div class="ahp-section">
        <div class="section-header">
            <h4>1. Matriks Perbandingan Berpasangan</h4>
            <span class="step-badge">Step 1</span>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        @foreach($kode as $k)
                            <th>{{ $k }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($kode as $i)
                    <tr>
                        <td class="fw-semibold">{{ $i }}</td>
                        @foreach($kode as $j)
                            <td>{{ $matriksTampil[$i][$j] ?? '-' }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= 2. NORMALISASI ================= --}}
    <div class="ahp-section">
        <div class="section-header">
            <h4>2. Matriks Normalisasi</h4>
            <span class="step-badge blue">Step 2</span>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        @foreach($kode as $k)
                            <th>{{ $k }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($kode as $i)
                    <tr>
                        <td class="fw-semibold">{{ $i }}</td>
                        @foreach($kode as $j)
                            <td>
                                {{ isset($normalisasi[$i][$j]) ? number_format($normalisasi[$i][$j], 3) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= 3. BOBOT ================= --}}
    <div class="ahp-section">
        <div class="section-header">
            <h4>3. Bobot Prioritas Kriteria (Wi)</h4>
            <span class="step-badge green">Final</span>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Bobot (Wi)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bobot as $k => $v)
                    <tr>
                        <td class="fw-semibold">{{ $k }}</td>
                        <td>
                            <span class="nilai-prioritas">
                                {{ number_format($v, 4) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-footer">
        <a href="/kriteria" class="btn-primary">
            <i class="fas fa-save"></i> Simpan & Gunakan Bobot
        </a>
    </div>

</div>

@endsection