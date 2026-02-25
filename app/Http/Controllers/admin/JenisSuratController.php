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
        DB::table('jenis_surat')->insert([
            'nama_jenis' => $request->nama_jenis,
            'nilai' => $request->nilai,
            'urgensi' => $request->urgensi,
        ]);

        return back()->with('success', 'Jenis surat berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('jenis_surat')->where('id', $id)->update([
            'nama_jenis' => $request->nama_jenis,
            'nilai' => $request->nilai,
            'urgensi' => $request->urgensi,
        ]);

        return back()->with('success', 'Jenis surat berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('jenis_surat')->where('id', $id)->delete();
        return back()->with('success', 'Jenis surat dihapus');
    }
}
