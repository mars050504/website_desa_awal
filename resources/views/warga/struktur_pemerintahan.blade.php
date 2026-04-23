@extends('layouts.warga')

@section('title', 'Struktur Pemerintahan Desa Bloro')

@section('content')

<div class="page-header">
    <h2>Struktur Pemerintahan Desa Bloro</h2>
    <p>Susunan organisasi pemerintahan desa</p>
</div>

<div class="org-tree">

    <!-- KEPALA DESA -->
    <div class="node kepala">
        <div class="card main card-flex">
            <img src="{{ $perangkat['kepala_desa']->foto ?? '/img/default.png' }}" class="avatar">
            <div>
                <strong>Kepala Desa</strong>
                <span>{{ $perangkat['kepala_desa']->nama ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- LEVEL 1 -->
    <div class="level level-1">

        <!-- KIRI -->
        <div class="branch kiri">

            <div class="kasi-row">

                <div class="card card-flex">
                    <img src="{{ $perangkat['kasi_pemerintahan']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Kasi Pemerintahan
                        <span>{{ $perangkat['kasi_pemerintahan']->nama ?? '-' }}</span>
                    </div>
                </div>

                <div class="card card-flex">
                    <img src="{{ $perangkat['kasi_kesejahteraan']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Kasi Kesejahteraan
                        <span>{{ $perangkat['kasi_kesejahteraan']->nama ?? '-' }}</span>
                    </div>
                </div>

                <div class="card card-flex">
                    <img src="{{ $perangkat['kasi_pelayanan']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Kasi Pelayanan
                        <span>{{ $perangkat['kasi_pelayanan']->nama ?? '-' }}</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- KANAN -->
        <div class="branch kanan">

            <div class="sekdes">
                <div class="card highlight card-flex">
                    <img src="{{ $perangkat['sekretaris_desa']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Sekretaris Desa
                        <span>{{ $perangkat['sekretaris_desa']->nama ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="kaur-row">

                <div class="card card-flex">
                    <img src="{{ $perangkat['kaur_tu']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Kaur TU & Umum
                        <span>{{ $perangkat['kaur_tu']->nama ?? '-' }}</span>
                    </div>
                </div>

                <div class="card card-flex">
                    <img src="{{ $perangkat['kaur_keuangan']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Kaur Keuangan
                        <span>{{ $perangkat['kaur_keuangan']->nama ?? '-' }}</span>
                    </div>
                </div>

                <div class="card card-flex">
                    <img src="{{ $perangkat['kaur_perencanaan']->foto ?? '/img/default.png' }}" class="avatar">
                    <div>
                        Kaur Perencanaan
                        <span>{{ $perangkat['kaur_perencanaan']->nama ?? '-' }}</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- LEVEL 2 -->
    <div class="level level-2">

        <div class="card small card-flex">
            <img src="{{ $perangkat['kadus_timur']->foto ?? '/img/default.png' }}" class="avatar">
            <div>
                Kadus Bloro Timur
                <span>{{ $perangkat['kadus_timur']->nama ?? '-' }}</span>
            </div>
        </div>

        <div class="card small card-flex">
            <img src="{{ $perangkat['kadus_tengah']->foto ?? '/img/default.png' }}" class="avatar">
            <div>
                Kadus Bloro Tengah
                <span>{{ $perangkat['kadus_tengah']->nama ?? '-' }}</span>
            </div>
        </div>

        <div class="card small card-flex">
            <img src="{{ $perangkat['kadus_barat']->foto ?? '/img/default.png' }}" class="avatar">
            <div>
                Kadus Bloro Barat
                <span>{{ $perangkat['kadus_barat']->nama ?? '-' }}</span>
            </div>
        </div>

        <div class="card small card-flex">
            <img src="{{ $perangkat['kadus_petak']->foto ?? '/img/default.png' }}" class="avatar">
            <div>
                Kadus Petak Taman
                <span>{{ $perangkat['kadus_petak']->nama ?? '-' }}</span>
            </div>
        </div>

    </div>

</div>

@endsection