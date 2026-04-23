@extends('layouts.admin')

@section('title', 'Setting Perangkat Desa')

@section('content')

<div class="page-header">
    <h2>Perangkat Desa</h2>
    <p>Kelola nama, foto perangkat desa, dan wallpaper dashboard</p>
</div>

{{-- ================= WALLPAPER ================= --}}
<div class="admin-card" style="margin-bottom:25px;">

    <h3>
        <i class="fas fa-image"></i> Wallpaper Dashboard
    </h3>

    <form action="{{ url('/setting/wallpaper') }}" method="POST" enctype="multipart/form-data" style="margin-top:10px;">
        @csrf
        <input type="file" name="wallpaper" required>

        <button class="btn-primary">
            <i class="fas fa-upload"></i> Upload Wallpaper
        </button>
    </form>

    @php
    $active = null;
    $activePath = public_path('images/wallpaper/active.txt');

    if (file_exists($activePath)) {
    $active = trim(file_get_contents($activePath));
    }

    $files = glob(public_path('images/wallpaper/*.{jpg,jpeg,png}'), GLOB_BRACE);
    @endphp

    <div style="margin-top:15px; display:flex; flex-wrap:wrap; gap:10px;">

        @foreach($files as $file)
        @php $name = basename($file); @endphp

        <div style="width:160px; border-radius:10px; overflow:hidden; border:2px solid {{ $active == $name ? '#1CC88A' : '#eee' }}; padding:5px;">

            <img src="{{ asset('images/wallpaper/'.$name) }}"
                style="width:100%; height:100px; object-fit:cover; border-radius:8px;">

            {{-- GUNAKAN --}}
            <form action="{{ url('/setting/wallpaper/set') }}" method="POST">
                @csrf
                <input type="hidden" name="file" value="{{ $name }}">

                <button class="btn-primary" style="width:100%; margin-top:5px;">
                    {{ $active == $name ? 'Aktif' : 'Gunakan' }}
                </button>
            </form>

            <form action="{{ url('/setting/wallpaper/delete') }}" method="POST" onsubmit="return confirm('Hapus wallpaper ini?')">
                @csrf
                <input type="hidden" name="file" value="{{ $name }}">

                <button class="btn-danger" style="width:100%; margin-top:5px;">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>


{{-- ================= PERANGKAT DESA ================= --}}
<div class="card-container">

    @php
    $jabatanList = [
    'kepala_desa' => 'Kepala Desa',
    'sekretaris_desa' => 'Sekretaris Desa',
    'kasi_pemerintahan' => 'Kasi Pemerintahan',
    'kasi_kesejahteraan' => 'Kasi Kesejahteraan',
    'kasi_pelayanan' => 'Kasi Pelayanan',
    'kaur_tu' => 'Kaur TU & Umum',
    'kaur_keuangan' => 'Kaur Keuangan',
    'kaur_perencanaan' => 'Kaur Perencanaan',
    'kadus_timur' => 'Kadus Bloro Timur',
    'kadus_tengah' => 'Kadus Bloro Tengah',
    'kadus_barat' => 'Kadus Bloro Barat',
    'kadus_petak' => 'Kadus Petak Taman',
    ];
    @endphp

    @foreach($jabatanList as $key => $label)

    <form action="{{ url('/setting/perangkat-desa') }}" method="POST" enctype="multipart/form-data" class="perangkat-card">
        @csrf

        <input type="hidden" name="jabatan" value="{{ $key }}">

        <h4>{{ $label }}</h4>

        <div class="foto-preview">
            @if(isset($perangkat[$key]) && $perangkat[$key]->foto)
            <img src="{{ $perangkat[$key]->foto }}">
            @else
            <div class="no-foto">No Image</div>
            @endif
        </div>

        <input
            type="text"
            name="nama"
            value="{{ $perangkat[$key]->nama ?? '' }}"
            placeholder="Masukkan nama"
            required>

        <input type="file" name="foto">

        <button type="submit" class="btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>

    </form>

    @endforeach

</div>

@endsection