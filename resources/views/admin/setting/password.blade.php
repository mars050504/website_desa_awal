@extends('layouts.admin')

@section('title', 'Ubah Password')

@section('content')

<div class="admin-card" style="max-width:500px; margin:auto;">

    <div class="admin-header">
        <h2 class="page-title">
            <i class="fas fa-key"></i> Ubah Password
        </h2>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/setting/update-password" class="form-admin">
        @csrf

        <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="old_password" required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="new_password" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="new_password_confirmation" required>
        </div>

        <button class="btn-primary">
            <i class="fas fa-save"></i> Update Password
        </button>

    </form>

</div>

@endsection