<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    // ================= CREATE =================
    public function create()
    {
        return view('admin.warga.create');
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'nik'      => 'required',
            'alamat'   => 'required',
            'phone'    => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'username'          => $request->email, // default username = email
            'password'          => Hash::make($request->password),
            'role'              => 'warga',
            'nik'               => $request->nik,
            'alamat'            => $request->alamat,
            'phone'             => $request->phone,
            'email_verified_at' => now()
        ]);

        return redirect('/warga')->with('success', 'Data warga berhasil ditambahkan');
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
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'username' => 'nullable|unique:users,username,' . $id,
            'nik'      => 'nullable',
            'alamat'   => 'nullable',
            'phone'    => 'nullable',
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username ?? $request->email,
            'nik'      => $request->nik,
            'alamat'   => $request->alamat,
            'phone'    => $request->phone,
        ];

        // 🔒 Password hanya diupdate kalau diisi
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $warga->update($data);

        return redirect('/warga')
            ->with('success', 'Data warga berhasil diperbarui');
    }

    // ================= DELETE =================
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
}
