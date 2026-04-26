@extends('layouts.admin')

@section('content')

<div class="page-title">Edit Data Warga</div>

<div class="admin-card">
    <form action="{{ url('/warga/'.$warga->id.'/update') }}" method="POST" class="form-admin">
        @csrf

        {{-- ================= DATA AKUN ================= --}}
        <h4>Akun</h4>

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ $warga->name }}" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ $warga->username }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $warga->email }}">
        </div>

        <div class="form-group">
            <label>Password (Kosongkan jika tidak diubah)</label>

            <div style="position: relative;">
                <input
                    type="password"
                    name="password"
                    id="password"
                    style="width: 100%; padding-right: 40px;">

                <!-- ICON MATA -->
                <span onclick="togglePassword()"
                    style="
                position:absolute;
                right:10px;
                top:50%;
                transform:translateY(-50%);
                cursor:pointer;
                font-size:18px;
              ">
                    👁️
                </span>
            </div>
        </div>

        {{-- ================= DATA WARGA ================= --}}
        <h4 style="margin-top:20px;">Data Warga</h4>

        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" value="{{ $warga->nik }}">
        </div>

        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="phone" value="{{ $warga->phone }}">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat">{{ $warga->alamat }}</textarea>
        </div>

        {{-- BUTTON --}}
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ url('/warga') }}" class="btn-edit">Batal</a>
        </div>
    </form>
</div>

@endsection
<script id="b0f7zk">
function togglePassword() {
    const input = document.getElementById("password");

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>
