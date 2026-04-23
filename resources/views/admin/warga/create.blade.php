@extends('layouts.admin')
@section('title', 'Tambah Warga')

@section('content')

<div class="page-header">
    <h2>Tambah Warga</h2>
    <p>Input data warga baru</p>
</div>

<div class="form-card modern-card">

    <form action="{{ url('/warga') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Warga</label>
            <input type="text" name="name" class="form-input" required>
        </div>

        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" class="form-input" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-input" rows="3" required></textarea>
        </div>

        <div class="form-actions">
            <a href="{{ url('/warga') }}" class="btn-edit">Kembali</a>
            <button type="submit" class="btn-primary">Simpan</button>
        </div>

    </form>

</div>

@endsection