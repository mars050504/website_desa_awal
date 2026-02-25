<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{
    // ================= HALAMAN PENGAJUAN + RIWAYAT =================
    public function pengajuan()
    {
        $surat = DB::table('surat')
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return view('warga.pengajuan-surat', compact('surat'));
    }

    // ================= HALAMAN RIWAYAT SAJA =================
    public function riwayat()
    {
        $surat = DB::table('surat')
            ->where('user_id', auth()->id()) // hanya milik user login
            ->orderByDesc('id')
            ->get();

        return view('warga.riwayat-surat', compact('surat'));
    }

    // ================= FORM AJUKAN SURAT =================
    public function create()
    {
        $jenisSurat = DB::table('jenis_surat')->get();
        return view('warga.ajukan', compact('jenisSurat'));
    }

    // ================= SIMPAN PENGAJUAN =================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'dok_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dok_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dok_pengantar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'tanggal' => now()->format('Y-m-d'),
        ];

        if ($request->hasFile('dok_ktp')) {
            $data['dok_ktp'] = $request->file('dok_ktp')->store('dokumen');
        }

        if ($request->hasFile('dok_kk')) {
            $data['dok_kk'] = $request->file('dok_kk')->store('dokumen');
        }

        if ($request->hasFile('dok_pengantar')) {
            $data['dok_pengantar'] = $request->file('dok_pengantar')->store('dokumen');
        }

        DB::table('surat')->insert($data);

        return redirect('/pengajuan-surat')
            ->with('success', 'Pengajuan surat berhasil dikirim');
    }

    // ================= FORM EDIT DOKUMEN =================
    public function edit($id)
    {
        $surat = DB::table('surat')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$surat) {
            abort(404);
        }

        return view('warga.edit', compact('surat'));
    }

    // ================= UPDATE DOKUMEN =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'dok_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dok_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dok_pengantar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('dok_ktp')) {
            $data['dok_ktp'] = $request->file('dok_ktp')->store('dokumen');
        }

        if ($request->hasFile('dok_kk')) {
            $data['dok_kk'] = $request->file('dok_kk')->store('dokumen');
        }

        if ($request->hasFile('dok_pengantar')) {
            $data['dok_pengantar'] = $request->file('dok_pengantar')->store('dokumen');
        }

        DB::table('surat')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update($data);

        return redirect('/pengajuan-surat')
            ->with('success', 'Dokumen berhasil diperbarui');
    }
}
