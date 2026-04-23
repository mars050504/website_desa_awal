@extends('layouts.admin')

@section('title', 'Hasil Perbandingan Kriteria')

@section('content')

<div class="page-header">
    <h2>Hasil Perhitungan AHP – Kriteria</h2>
    <p>Proses perhitungan bobot menggunakan metode Analytical Hierarchy Process</p>
</div>

<div class="table-card modern-card">

    {{-- ================= 1. MATRIKS ================= --}}
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

    {{-- ================= 4. KONSISTENSI ================= --}}
    <div class="ahp-section">
        <div class="section-header">
            <h4>4. Uji Konsistensi</h4>
            <span class="step-badge orange">Validation</span>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <tbody>
                    <tr>
                        <td>λ max</td>
                        <td>{{ number_format($lambdaMax, 4) }}</td>
                    </tr>
                    <tr>
                        <td>Consistency Index (CI)</td>
                        <td>{{ number_format($CI, 4) }}</td>
                    </tr>
                    <tr>
                        <td>Consistency Ratio (CR)</td>
                        <td>
                            <strong>{{ number_format($CR, 4) }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Status Konsistensi</td>
                        <td>
                            @if($CR < 0.1)
                                <span class="badge-success">Konsisten</span>
                                @else
                                <span class="badge-danger">Tidak Konsisten</span>
                                @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= STATUS ================= --}}
    <div class="form-footer">

        @if($CR < 0.1)

            <form method="POST" action="/kriteria/simpan-bobot">
            @csrf

            @foreach($bobot as $k => $v)
            <input type="hidden" name="bobot[{{ $k }}]" value="{{ $v }}">
            @endforeach

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Simpan Bobot ke Database
            </button>
            </form>

            @else

            <a href="/perbandingan-kriteria" class="btn-danger">
                <i class="fas fa-redo"></i> Perbaiki Perbandingan
            </a>

            @endif

    </div>

</div>

@endsection