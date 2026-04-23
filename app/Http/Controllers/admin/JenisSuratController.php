<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenis = DB::table('jenis_surat')->orderBy('id')->get();
        return view('admin.jenis-surat.index', compact('jenis'));
    }

    public function store(Request $request)
    {

        if ($request->urgensi == 'Tidak Mendesak') {
            $nilai = 1;
        } elseif ($request->urgensi == 'Tergolong Menengah') {
            $nilai = 2;
        } else {
            $nilai = 3;
        }

        DB::table('jenis_surat')->insert([
            'nama_jenis' => $request->nama_jenis,
            'urgensi' => $request->urgensi,
            'nilai' => $nilai
        ]);

        return back()->with('success', 'Jenis surat berhasil ditambahkan');
    }

    public function updateNilai(Request $request, $id)
    {
        $nilai = $request->nilai;

        if ($nilai == 1) {
            $urgensi = 'Tidak Mendesak';
        } elseif ($nilai == 2) {
            $urgensi = 'Tergolong Menengah';
        } elseif ($nilai == 3) {
            $urgensi = 'Mendesak';
        } else {
            $urgensi = 'Tidak Mendesak'; // default aman
        }
        DB::table('jenis_surat')
            ->where('id', $id)
            ->update([
                'nilai' => $nilai,
                'urgensi' => $urgensi
            ]);

        return back()->with('success', 'Nilai & urgensi berhasil diperbarui');
    }
}
