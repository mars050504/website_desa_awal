@extends('layouts.warga')

@section('content')

<div class="container-warga">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-warga">

        <div class="card-header-warga">
            <h3><i class="fas fa-file-alt"></i> Pengajuan Surat</h3>
            <span class="card-subtitle">Isi formulir dengan lengkap dan benar</span>
        </div>

        <form method="POST" action="/ajukan-surat" enctype="multipart/form-data" class="form-warga">
            @csrf

            <!-- DATA PEMOHON -->
            <div class="form-section">
                <h4><i class="fas fa-user"></i> Data Pemohon</h4>

                <div class="form-group">
                    <label>Nama Pemohon</label>
                    <input type="text" name="nama"
                           value="{{ auth()->user()->name }}" readonly>
                </div>

                <div class="form-group">
                    <label>Jenis Surat</label>
                    <select name="jenis" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach($jenisSurat as $j)
                            <option value="{{ $j->nama_jenis }}">{{ $j->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="divider">

            <!-- DOKUMEN -->
            <div class="form-section">
                <h4><i class="fas fa-folder-open"></i> Dokumen Pendukung (Opsional)</h4>

                <div class="form-group file-upload">
                    <label><i class="fas fa-id-card"></i> KTP</label>
                    <input type="file" name="dok_ktp">
                </div>

                <div class="form-group file-upload">
                    <label><i class="fas fa-users"></i> Kartu Keluarga</label>
                    <input type="file" name="dok_kk">
                </div>

                <div class="form-group file-upload">
                    <label><i class="fas fa-file-signature"></i> Surat Pengantar</label>
                    <input type="file" name="dok_pengantar">
                </div>
            </div>

            <div class="form-action">
                <button class="btn-primary btn-submit">
                    <i class="fas fa-paper-plane"></i> Ajukan Surat
                </button>
            </div>

        </form>

    </div>
</div>

@endsection