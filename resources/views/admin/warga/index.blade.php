@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h2>Kelola Data Warga</h2>
    <p>Manajemen data penduduk desa</p>
</div>

<div class="table-card modern-card">

    <div class="card-header">
        <div>
            <h4>Daftar Warga</h4>
        </div>

        <div class="card-toolbar">
            <input type="text" class="search-input" placeholder="Cari warga...">
            <a href="#" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Warga
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama Warga</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warga as $w)
                <tr>
                    <td class="fw-semibold">{{ $w->name }}</td>
                    <td>{{ $w->nik ?? '-' }}</td>
                    <td>{{ $w->alamat ?? '-' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ url('/warga/'.$w->id.'/edit') }}" class="btn-edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            <form action="{{ url('/warga/'.$w->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus warga ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        Belum ada data warga
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection