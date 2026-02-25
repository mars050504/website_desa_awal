@extends('layouts.admin')

@section('content')

<div class="page-title">Detail Surat</div>

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
        <input type="text" value="{{ $surat->jenis }}" readonly>
    </div>

    <div class="form-group">
        <label>Tanggal Pengajuan</label>
        <input type="text"
            value="{{ \Carbon\Carbon::parse($surat->tanggal)->format('d M Y') }}"
            readonly>
    </div>
    <div class="form-group">
            <label>KTP</label>
            @if($surat->dok_ktp)
                <a href="{{ asset('storage/'.$surat->dok_ktp) }}"
                   target="_blank"
                   class="btn-view action-btn">
                   Lihat Dokumen
                </a>
            @else
                <span class="status-badge status-proses">Belum Upload</span>
            @endif
        </div>

        <div class="form-group">
            <label>Kartu Keluarga</label>
            @if($surat->dok_kk)
                <a href="{{ asset('storage/'.$surat->dok_kk) }}"
                   target="_blank"
                   class="btn-view action-btn">
                   Lihat Dokumen
                </a>
            @else
                <span class="status-badge status-proses">Belum Upload</span>
            @endif
        </div>

        <div class="form-group">
            <label>Surat Pengantar</label>
            @if($surat->dok_pengantar)
                <a href="{{ asset('storage/'.$surat->dok_pengantar) }}"
                   target="_blank"
                   class="btn-view action-btn">
                   Lihat Dokumen
                </a>
            @else
                <span class="status-badge status-proses">Belum Upload</span>
            @endif
        </div>

    <div class="divider"></div>

    <h4 style="margin-bottom:15px;">Update Status Surat</h4>

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
                placeholder="Contoh: Dokumen belum lengkap / Surat sedang diverifikasi / Pengajuan ditolak karena data tidak sesuai">{{ $surat->keterangan }}</textarea>
        </div>

        <button class="btn-success">💾 Simpan Perubahan</button>
    </form>

    <div style="margin-top:25px;">
        <a href="{{ url('/kelola-surat') }}" class="btn-edit">
            ← Kembali
        </a>
    </div>

</div>
</div>

@endsection