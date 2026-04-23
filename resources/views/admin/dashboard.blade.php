@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-header">
    <h2>Dashboard Sistem Pelayanan Desa</h2>
    <p>Ringkasan informasi sistem dan aktivitas terbaru</p>
</div>


{{-- ================= STATISTIK ================= --}}
<div class="stats-grid">

    <div class="stat-card primary">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalWarga }}</h3>
            <span>Total Warga</span>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalSurat }}</h3>
            <span>Total Pengajuan</span>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalJenis }}</h3>
            <span>Jenis Surat</span>
        </div>
    </div>

    <div class="stat-card info">
        <div class="stat-icon">
            <i class="fas fa-balance-scale"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalKriteria }}</h3>
            <span>Kriteria AHP</span>
        </div>
    </div>

</div>

{{-- ================= GRAFIK ================= --}}
<div class="dashboard-card">

    <div class="dashboard-card-header">
        <h4>Grafik Pengajuan Surat</h4>
    </div>

    <div class="chart-container">
        <canvas id="grafikSurat" data-grafik='@json($grafik)'></canvas>
    </div>

</div>

{{-- ================= PERMOHONAN TERBARU ================= --}}
<div class="dashboard-card">

    <div class="dashboard-card-header">
        <h4>3 Permohonan Terbaru</h4>
    </div>

    <table class="dashboard-table">

        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Surat</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>

            @foreach($prioritas as $p)

            <tr>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->jenis }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
            </tr>

            @endforeach

        </tbody>

    </table>

</div>



{{-- ================= SCRIPT GRAFIK ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const canvas = document.getElementById('grafikSurat');

        if (!canvas) return;

        const dataGrafik = JSON.parse(canvas.dataset.grafik);

        const bulan = dataGrafik.map(function(item) {
            return item.bulan;
        });

        const total = dataGrafik.map(function(item) {
            return item.total;
        });

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: total,
                    backgroundColor: [
                        '#4E73DF',
                        '#1CC88A',
                        '#36b9cc',
                        '#f6c23e'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

    });
</script>

@endsection