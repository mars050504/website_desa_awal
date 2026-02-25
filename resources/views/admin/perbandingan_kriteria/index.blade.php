@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h2>Perbandingan Kriteria (AHP)</h2>
    <p>Input nilai perbandingan menggunakan Skala Saaty</p>
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
                        <th width="260">Nilai (Skala Saaty)</th>
                    </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < count($kriteria); $i++)
                    @for($j = $i+1; $j < count($kriteria); $j++)
                    <tr>
                        <td>
                            <div class="kriteria-box">
                                <strong>{{ $kriteria[$i]->nama_kriteria }}</strong>
                                <small>{{ $kriteria[$i]->kode }}</small>
                            </div>
                        </td>

                        <td>
                            <div class="kriteria-box">
                                <strong>{{ $kriteria[$j]->nama_kriteria }}</strong>
                                <small>{{ $kriteria[$j]->kode }}</small>
                            </div>
                        </td>

                        <td>
                            <select name="nilai[{{ $kriteria[$i]->kode }}-{{ $kriteria[$j]->kode }}]"
                                    class="select-modern" required>
                                <option value="">-- Pilih Nilai --</option>
                                <option value="1">1 - Sama penting</option>
                                <option value="3">3 - Sedikit lebih penting</option>
                                <option value="5">5 - Lebih penting</option>
                                <option value="7">7 - Sangat penting</option>
                                <option value="9">9 - Mutlak lebih penting</option>
                                <option value="1/3">1/3 - Sedikit kurang penting</option>
                                <option value="1/5">1/5 - Kurang penting</option>
                                <option value="1/7">1/7 - Sangat kurang penting</option>
                                <option value="1/9">1/9 - Mutlak kurang penting</option>
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