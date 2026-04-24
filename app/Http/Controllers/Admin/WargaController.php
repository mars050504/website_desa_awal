<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    // ================= LIST WARGA =================
    public function index()
    {
        $warga = User::where('role', 'warga')
            ->orderBy('name')
            ->get();

        return view('admin.warga.index', compact('warga'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $warga = User::where('role', 'warga')->find($id);

        if (!$warga) {
            abort(404);
        }

        return view('admin.warga.edit', compact('warga'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $warga = User::where('role', 'warga')->find($id);

        if (!$warga) {
            abort(404);
        }

        $request->validate([
            'name'   => 'required',
            'nik'    => 'nullable',
            'alamat' => 'nullable',
        ]);

        $warga->update([
            'name'   => $request->name,
            'nik'    => $request->nik,
            'alamat' => $request->alamat,
        ]);

        return redirect('/warga')
            ->with('success', 'Data warga berhasil diperbarui');
    }

    // ================= HAPUS =================
    public function destroy($id)
    {
        $warga = User::where('role', 'warga')->find($id);

        if (!$warga) {
            abort(404);
        }

        $warga->delete();

        return redirect('/warga')
            ->with('success', 'Data warga berhasil dihapus');
    }
    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required|unique:wargas,nik',
            'alamat' => 'required'
        ]);

        Warga::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'alamat' => $request->alamat
        ]);

        return redirect('/warga')->with('success', 'Data warga berhasil ditambahkan');
    }
}
