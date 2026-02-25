<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    // ================= LIST SURAT =================
    public function index()
    {
        $surats = Surat::orderBy('id', 'desc')->get();

        return view('admin.surat', compact('surats'));
    }

    // ================= DETAIL SURAT =================
    public function show($id)
    {
        $surat = Surat::find($id);

        if (!$surat) {
            abort(404);
        }

        return view('admin.surat.detail', compact('surat'));
    }

    // ================= UPDATE STATUS + KETERANGAN =================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Selesai,Ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $surat = Surat::find($id);

        if (!$surat) {
            abort(404);
        }

        $surat->status = $request->status;
        $surat->keterangan = $request->keterangan;
        $surat->save();

        return redirect()->back()
            ->with('success', 'Status dan keterangan berhasil diperbarui');
    }

    // ================= HAPUS SURAT =================
    public function destroy($id)
    {
        $surat = Surat::find($id);

        if (!$surat) {
            abort(404);
        }

        $surat->delete();

        return redirect('/kelola-surat')
            ->with('success', 'Surat berhasil dihapus');
    }
}
