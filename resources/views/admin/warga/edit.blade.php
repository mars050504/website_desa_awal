@extends('layouts.admin')

@section('content')

<div class="page-title">Edit Data Warga</div>

<div class="admin-card">
    <form action="{{ url('/warga/'.$warga->id.'/update') }}" method="POST" class="form-admin">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ $warga->name }}" required>
        </div>

        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" value="{{ $warga->nik }}">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat">{{ $warga->alamat }}</textarea>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ url('/warga') }}" class="btn-edit">Batal</a>
        </div>
    </form>
</div>

@endsection
