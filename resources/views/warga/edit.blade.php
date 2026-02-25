@extends('layouts.warga')

@section('content')

<div class="container-warga">

    <div class="card-warga">

        <div class="card-header-warga">
            <h3>Lengkapi Dokumen</h3>
        </div>

        <form method="POST"
              action="/surat/{{ $surat->id }}/update"
              enctype="multipart/form-data"
              class="form-warga">

            @csrf

            {{-- KTP --}}
            <div class="form-group">
                <label>KTP</label>

                @if($surat->dok_ktp)
                    <div class="file-info">
                        <span class="badge-success">Sudah Upload</span>
                        <a href="{{ asset('storage/'.$surat->dok_ktp) }}"
                           target="_blank"
                           class="file-link">
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
                        <a href="{{ asset('storage/'.$surat->dok_kk) }}"
                           target="_blank"
                           class="file-link">
                           Lihat File
                        </a>
                    </div>
                @endif

                <input type="file" name="dok_kk">
            </div>

            {{-- Surat Pengantar --}}
            <div class="form-group">
                <label>Surat Pengantar</label>

                @if($surat->dok_pengantar)
                    <div class="file-info">
                        <span class="badge-success">Sudah Upload</span>
                        <a href="{{ asset('storage/'.$surat->dok_pengantar) }}"
                           target="_blank"
                           class="file-link">
                           Lihat File
                        </a>
                    </div>
                @endif

                <input type="file" name="dok_pengantar">
            </div>

            <div style="margin-top:20px;">
                <button type="submit" class="btn-primary">
                    Simpan Dokumen
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
