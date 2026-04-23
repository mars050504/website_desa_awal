@extends('layouts.warga')

@section('title', 'Riwayat Surat')

@section('content')

<div class="container-warga">

    <div class="card-warga">

        <div class="card-header-warga">
            <h3><i class="fas fa-history"></i> Riwayat Pengajuan Surat</h3>
            <span class="card-subtitle">Daftar surat yang pernah diajukan</span>
        </div>

        @if($surat->isEmpty())

        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <p>Belum ada riwayat pengajuan surat.</p>
        </div>

        @else

        <div class="table-responsive">

            <table class="table-warga">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($surat as $s)

                    <tr>

                        {{-- NOMOR --}}
                        <td>
                            <span class="no-badge">{{ $loop->iteration }}</span>
                        </td>

                        {{-- JENIS --}}
                        <td>
                            <div class="jenis-badge">
                                <i class="fas fa-file-alt"></i>
                                {{ $s->nama_jenis ?? $s->jenis }}
                            </div>
                        </td>

                        {{-- TANGGAL --}}
                        <td>
                            {{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}
                        </td>

                        {{-- DOKUMEN --}}
                        <td>
                            <div class="doc-status">

                                <span class="{{ $s->dok_ktp ? 'text-success' : 'text-danger' }}">
                                    <i class="fas {{ $s->dok_ktp ? 'fa-check' : 'fa-times' }}"></i> KTP
                                </span>

                                <span class="{{ $s->dok_kk ? 'text-success' : 'text-danger' }}">
                                    <i class="fas {{ $s->dok_kk ? 'fa-check' : 'fa-times' }}"></i> KK
                                </span>

                                <span class="{{ $s->dok_pengantar ? 'text-success' : 'text-danger' }}">
                                    <i class="fas {{ $s->dok_pengantar ? 'fa-check' : 'fa-times' }}"></i> Pendukung
                                </span>

                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($s->status == 'Diproses')
                            <span class="badge-warning">Diproses</span>
                            @elseif($s->status == 'Selesai')
                            <span class="badge-success">Selesai</span>
                            @elseif($s->status == 'Ditolak')
                            <span class="badge-danger">Ditolak</span>
                            @endif
                        </td>

                        {{-- KETERANGAN --}}
                        <td>
                            {{ $s->keterangan ?? '-' }}
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="aksi-group">

                                {{-- ✏️ EDIT + DETAIL --}}
                                @if($s->status != 'Selesai')
                                <a href="{{ route('surat.edit', $s->id) }}"
                                    class="btn-icon btn-edit"
                                    title="Lihat & Edit Data">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @else
                                <span class="badge-success mini">
                                    <i class="fas fa-check"></i>
                                </span>
                                @endif

                                {{-- 🗑 DELETE --}}
                                <form action="/hapus-surat/{{ $s->id }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn-icon btn-delete"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @endif

    </div>

</div>

@endsection