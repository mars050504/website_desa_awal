@extends('layouts.warga')

@section('content')

<div class="container-warga">

    <div class="card-warga">

        <div class="card-header-warga">
            <h3>Edit Data Pengajuan</h3>
        </div>

        <form method="POST"
              action="/surat/{{ $surat->id }}/update"
              enctype="multipart/form-data"
              class="form-warga">

            @csrf

            {{-- ================= DATA WARGA ================= --}}
            <h4 style="margin-bottom:15px;">Data Pemohon</h4>

            <div class="form-grid">

                @foreach($details as $field => $value)
                <div class="form-group">
                    <label>{{ ucwords(str_replace('_',' ',$field)) }}</label>
                    <input type="text" name="{{ $field }}" value="{{ $value }}">
                </div>
                @endforeach

            </div>

            {{-- ================= DOKUMEN ================= --}}
            <h4 style="margin-top:30px;">Dokumen</h4>

            <div class="form-grid">

                {{-- KTP --}}
                <div class="form-group">
                    <label>KTP</label>

                    @if($surat->dok_ktp)
                        <div class="file-info">
                            <span class="badge-success">Sudah Upload</span>
                            <a href="{{ $surat->dok_ktp }}" target="_blank" class="file-link">
                               Lihat File
                            </a>
                        </div>
                    @endif

                    <input type="file" name="dok_ktp">
                </div>

                {{-- KK --}}
                <div class="form-group">
                    <label>Kartu Keluarga</label>

                    @if($surat->dok_kk)
                        <div class="file-info">
                            <span class="badge-success">Sudah Upload</span>
                            <a href="{{ $surat->dok_kk }}" target="_blank" class="file-link">
                               Lihat File
                            </a>
                        </div>
                    @endif

                    <input type="file" name="dok_kk">
                </div>

                {{-- Pengantar --}}
                <div class="form-group">
                    <label>Surat Pengantar</label>

                    @if($surat->dok_pengantar)
                        <div class="file-info">
                            <span class="badge-success">Sudah Upload</span>
                            <a href="{{ $surat->dok_pengantar }}" target="_blank" class="file-link">
                               Lihat File
                            </a>
                        </div>
                    @endif

                    <input type="file" name="dok_pengantar">
                </div>

            </div>

            {{-- BUTTON --}}
            <div style="margin-top:25px; display:flex; gap:10px;">

                {{-- 🔙 KEMBALI --}}
                <a href="/riwayat-surat" class="btn-warning">
                    ← Kembali
                </a>

                {{-- 💾 SIMPAN --}}
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection