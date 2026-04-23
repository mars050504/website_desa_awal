@extends('layouts.admin')

@section('content')

<div class="page-title">
    <i class="fas fa-file-alt"></i> Detail Surat
</div>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card">
    <div class="form-admin">

        <div class="form-group">
            <label>Nama Pemohon</label>
            <input type="text" value="{{ $surat->nama }}" readonly>
        </div>

        <div class="form-group">
            <label>Jenis Surat</label>
            <input type="text"
                value="{{ DB::table('jenis_surat')->where('id', $surat->jenis)->value('nama_jenis') }}"
                readonly>
        </div>

        <div class="form-group">
            <label>Tanggal Pengajuan</label>
            <input type="text"
                value="{{ \Carbon\Carbon::parse($surat->tanggal)->format('d M Y') }}"
                readonly>
        </div>

        <div class="divider"></div>
        <h4 style="margin-bottom:15px;">
            <i class="fas fa-paperclip"></i> Dokumen
        </h4>

        <div class="form-group">
            <label>KTP</label>
            @if($surat->dok_ktp)
            <a href="{{ $surat->dok_ktp }}" target="_blank" class="btn-view action-btn">
                <i class="fas fa-eye"></i> Lihat Dokumen
            </a>
            @else
            <span class="status-badge status-proses">Belum Upload</span>
            @endif
        </div>

        <div class="form-group">
            <label>Kartu Keluarga</label>
            @if($surat->dok_kk)
            <a href="{{ $surat->dok_kk }}" target="_blank" class="btn-view action-btn">
                <i class="fas fa-eye"></i> Lihat Dokumen
            </a>
            @else
            <span class="status-badge status-proses">Belum Upload</span>
            @endif
        </div>

        <div class="form-group">
            <label>Surat Pengantar</label>
            @if($surat->dok_pengantar)
            <a href="{{ $surat->dok_pengantar }}" target="_blank" class="btn-view action-btn">
                <i class="fas fa-eye"></i> Lihat Dokumen
            </a>
            @else
            <span class="status-badge status-proses">Belum Upload</span>
            @endif
        </div>

        <div class="divider"></div>
        <h4 style="margin-bottom:15px;">
            <i class="fas fa-cog"></i> Update Status Surat
        </h4>

        <form method="POST" action="{{ url('/kelola-surat/'.$surat->id.'/update-status') }}">
            @csrf

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Diproses" {{ $surat->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $surat->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditolak" {{ $surat->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="form-group">
                <label>Keterangan Admin</label>
                <textarea name="keterangan" rows="4"
                    placeholder="Contoh: Dokumen belum lengkap / Surat sedang diverifikasi">{{ $surat->keterangan }}</textarea>
            </div>

            @php
                $phone = optional($surat->user)->phone;
                $wa = $phone ? preg_replace('/^0/', '62', $phone) : null;

                $pesan = urlencode(
                    "Halo, pengajuan surat Anda dengan jenis ".
                    DB::table('jenis_surat')->where('id', $surat->jenis)->value('nama_jenis').
                    " saat ini berstatus: ".$surat->status.
                    ($surat->keterangan ? "\nKeterangan: ".$surat->keterangan : "")
                );
            @endphp

            <div style="display:flex; gap:10px; align-items:center; margin-top:10px;">

                <button class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Status
                </button>

                @if($wa)
                    <a href="https://wa.me/{{ $wa }}?text={{ $pesan }}"
                       target="_blank"
                       class="btn-primary"
                       style="display:inline-flex; align-items:center; gap:6px;">
                       
                       <i class="fab fa-whatsapp"></i> Chat WA
                    </a>
                @else
                    <span style="font-size:12px; color:#999;">
                        No WA belum tersedia
                    </span>
                @endif

            </div>

        </form>

        <div class="divider"></div>
        <h4 style="margin-bottom:15px;">
            <i class="fas fa-pen"></i> Edit Isi Surat
        </h4>

        @php
            $isiFix = preg_replace('/(\b[\w\s]+\b),\s*\1,/i', '$1,', $isi);
        @endphp

        <form method="POST" action="{{ url('/kelola-surat/'.$surat->id.'/update-isi') }}">
            @csrf

            <textarea name="isi" id="editor" style="width:100%; height:400px;">{{ trim($isiFix) }}</textarea>

            <br><br>

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Simpan Isi Surat
            </button>

            <a href="{{ url('/kelola-surat/'.$surat->id.'/pdf') }}" target="_blank" class="btn-primary">
                <i class="fas fa-eye"></i> Preview PDF
            </a>

            <a href="{{ url('/kelola-surat/'.$surat->id.'/download') }}" class="btn-primary">
                <i class="fas fa-download"></i> Download PDF
            </a>
        </form>

        <div style="margin-top:25px;">
            <a href="{{ url('/kelola-surat') }}" class="btn-edit">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    let editor = CKEDITOR.replace('editor');

    editor.on('instanceReady', function() {
        let data = editor.getData();
        data = data.replace(/(\b[\w\s]+\b),\s*\1,/gi, '$1,');
        editor.setData(data);
    });
</script>

@endsection