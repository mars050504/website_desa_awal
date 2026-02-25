<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatif = DB::table('alternatif')
            ->orderBy('kode')
            ->get();

        return view('admin.alternatif.index', compact('alternatif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama_alternatif' => 'required'
        ]);

        DB::table('alternatif')->insert([
            'kode' => $request->kode,
            'nama_alternatif' => $request->nama_alternatif,
            'keterangan' => $request->keterangan,
            'aktif' => 1
        ]);

        return back()->with('success', 'Alternatif berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('alternatif')
            ->where('id', $id)
            ->update([
                'nama_alternatif' => $request->nama_alternatif,
                'keterangan' => $request->keterangan,
                'aktif' => $request->aktif
            ]);

        return back()->with('success', 'Alternatif berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('alternatif')->where('id', $id)->delete();
        return back()->with('success', 'Alternatif berhasil dihapus');
    }
}
