@extends('layouts.warga')

@section('title', 'Profil Saya')

@section('content')

<div class="container-warga">

    <div class="card-warga" style="max-width:700px; margin:auto;">

        <div class="card-header-warga">
            <h3><i class="fas fa-user-circle"></i> Profil Saya</h3>
            <span class="card-subtitle">Kelola data akun Anda</span>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/profil/update') }}" class="form-warga">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       required>
            </div>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik"
                       value="{{ old('nik', auth()->user()->nik) }}">
            </div>

            <div class="form-group">
                <label>No. Telepon (WhatsApp)</label>
                <input type="text" name="phone"
                       value="{{ old('phone', auth()->user()->phone) }}"
                       placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat"
                       value="{{ old('alamat', auth()->user()->alamat) }}">
            </div>

            <div class="form-group">
                <label>Password Baru (opsional)</label>
                <input type="password" name="password">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation">
            </div>

            <div style="margin-top:20px; display:flex; gap:10px;">

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ url('/') }}" class="btn-warning">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection