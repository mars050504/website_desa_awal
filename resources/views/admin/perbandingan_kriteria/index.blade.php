@extends('layouts.admin')

@section('title', 'Perbandingan Kriteria')

@section('content')

<div class="page-header">
    <h2>Perbandingan Kriteria (AHP)</h2>
    <p>Bandingkan tingkat kepentingan antar kriteria menggunakan Skala Saaty</p>
</div>

<div class="table-card modern-card">

    <div class="card-header">
        <h4>Matriks Perbandingan Berpasangan</h4>
        <span class="info-badge">Total Kriteria: {{ count($kriteria) }}</span>
    </div>

    <form method="POST" action="/perbandingan-kriteria/hitung">
        @csrf

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kriteria 1</th>
                        <th>Kriteria 2</th>
                        <th width="300">Nilai Perbandingan</th>
                    </tr>
                </thead>
                <tbody>

                @for($i = 0; $i < count($kriteria); $i++)
                    @for($j = $i+1; $j < count($kriteria); $j++)
                    <tr>

                        {{-- Kriteria 1 --}}
                        <td>
                            <div class="kriteria-box">
                                <strong>{{ $kriteria[$i]->nama_kriteria }}</strong>
                                <small>{{ $kriteria[$i]->kode }}</small>
                            </div>
                        </td>

                        {{-- Kriteria 2 --}}
                        <td>
                            <div class="kriteria-box">
                                <strong>{{ $kriteria[$j]->nama_kriteria }}</strong>
                                <small>{{ $kriteria[$j]->kode }}</small>
                            </div>
                        </td>

                        {{-- Nilai --}}
                        <td>
                            <select 
                                name="nilai[{{ $kriteria[$i]->kode }}][{{ $kriteria[$j]->kode }}]" 
                                class="select-modern" 
                                required
                            >
                                <option value="">-- Pilih Nilai --</option>

                                <option value="1">1 - Sama penting</option>
                                <option value="3">3 - {{ $kriteria[$i]->kode }} sedikit lebih penting</option>
                                <option value="5">5 - {{ $kriteria[$i]->kode }} lebih penting</option>
                                <option value="7">7 - {{ $kriteria[$i]->kode }} sangat penting</option>
                                <option value="9">9 - {{ $kriteria[$i]->kode }} mutlak lebih penting</option>

                                <option value="0.333">1/3 - {{ $kriteria[$j]->kode }} sedikit lebih penting</option>
                                <option value="0.2">1/5 - {{ $kriteria[$j]->kode }} lebih penting</option>
                                <option value="0.142">1/7 - {{ $kriteria[$j]->kode }} sangat penting</option>
                                <option value="0.111">1/9 - {{ $kriteria[$j]->kode }} mutlak lebih penting</option>
                            </select>
                        </td>

                    </tr>
                    @endfor
                @endfor

                </tbody>
            </table>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-primary">
                <i class="fas fa-calculator"></i> Simpan & Hitung Prioritas
            </button>
        </div>

    </form>

</div>

@endsection