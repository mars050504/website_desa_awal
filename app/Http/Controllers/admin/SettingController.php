<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $berita = DB::table('berita')->orderByDesc('id')->get();
        return view('admin.setting.index', compact('berita'));
    }

    public function storeBerita(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'created_at' => now()
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita');
        }

        DB::table('berita')->insert($data);

        return back()->with('success', 'Berita berhasil ditambahkan');
    }

    public function editBerita($id)
    {
        $berita = DB::table('berita')->where('id', $id)->first();
        return view('admin.setting.edit-berita', compact('berita'));
    }

    public function updateBerita(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'updated_at' => now()
        ];

        if ($request->hasFile('gambar')) {
            $lama = DB::table('berita')->where('id', $id)->value('gambar');
            if ($lama) Storage::delete($lama);

            $data['gambar'] = $request->file('gambar')->store('berita');
        }

        DB::table('berita')->where('id', $id)->update($data);

        return redirect('/setting')->with('success', 'Berita berhasil diperbarui');
    }

    public function deleteBerita($id)
    {
        $gambar = DB::table('berita')->where('id', $id)->value('gambar');
        if ($gambar) Storage::delete($gambar);

        DB::table('berita')->where('id', $id)->delete();

        return back()->with('success', 'Berita berhasil dihapus');
    }
}
