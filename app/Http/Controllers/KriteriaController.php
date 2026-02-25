<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = DB::table('kriteria')->orderBy('kode')->get();
        return view('admin.kriteria.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama_kriteria' => 'required',
            'bobot' => 'required|numeric'
        ]);

        DB::table('kriteria')->insert([
            'kode' => $request->kode,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,
            'aktif' => 1
        ]);

        return back()->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('kriteria')
            ->where('id', $id)
            ->update([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot
            ]);

        return back()->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('kriteria')->where('id', $id)->delete();
        return back()->with('success', 'Kriteria berhasil dihapus');
    }
}
