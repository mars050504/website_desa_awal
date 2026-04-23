<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternatifController extends Controller
{
    // =============================
    // 1. TAMPILKAN JENIS SURAT
    // =============================
    public function index()
    {
        $jenisSurat = DB::table('jenis_surat')
            ->orderBy('id')
            ->get();

        return view('admin.alternatif.index', compact('jenisSurat'));
    }

    // =============================
    // 2. UPDATE NILAI / URGENSI (OPSIONAL)
    // =============================
    public function update(Request $request, $id)
    {
        DB::table('jenis_surat')
            ->where('id', $id)
            ->update([
                'nilai' => $request->nilai,
                'urgensi' => $request->urgensi
            ]);

        return back()->with('success', 'Data jenis surat berhasil diperbarui');
    }
}