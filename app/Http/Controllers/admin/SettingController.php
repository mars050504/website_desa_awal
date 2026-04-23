<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    // ================= BERITA (LIST) =================
    public function berita()
    {
        $berita = DB::table('berita')->orderByDesc('id')->get();
        return view('admin.setting.berita', compact('berita'));
    }

    // ================= SIMPAN BERITA =================
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
            $upload = Cloudinary::upload(
                $request->file('gambar')->getRealPath()
            );
            $data['gambar'] = $upload->getSecurePath();
        }

        DB::table('berita')->insert($data);

        return back()->with('success', 'Berita berhasil ditambahkan');
    }

    // ================= EDIT BERITA =================
    public function editBerita($id)
    {
        $berita = DB::table('berita')->where('id', $id)->first();
        return view('admin.setting.edit-berita', compact('berita'));
    }

    // ================= UPDATE BERITA =================
    public function updateBerita(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $berita = DB::table('berita')->where('id', $id)->first();

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'updated_at' => now()
        ];

        if ($request->hasFile('gambar')) {

            if ($berita && $berita->gambar) {
                $publicId = $this->getPublicId($berita->gambar);
                Cloudinary::destroy($publicId);
            }

            $upload = Cloudinary::upload(
                $request->file('gambar')->getRealPath()
            );

            $data['gambar'] = $upload->getSecurePath();
        }

        DB::table('berita')->where('id', $id)->update($data);

        return redirect('/setting/berita')->with('success', 'Berita berhasil diperbarui');
    }

    // ================= DELETE BERITA =================
    public function deleteBerita($id)
    {
        $berita = DB::table('berita')->where('id', $id)->first();

        if ($berita && $berita->gambar) {
            $publicId = $this->getPublicId($berita->gambar);
            Cloudinary::destroy($publicId);
        }

        DB::table('berita')->where('id', $id)->delete();

        return back()->with('success', 'Berita berhasil dihapus');
    }

    // ================= HALAMAN PASSWORD =================
    public function password()
    {
        return view('admin.setting.password');
    }

    // ================= UPDATE PASSWORD =================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui');
    }

    // ================= PERANGKAT DESA =================
    public function perangkatDesa()
    {
        $perangkat = DB::table('perangkat_desas')->get()->keyBy('jabatan');
        return view('admin.setting.perangkat-desa', compact('perangkat'));
    }

    // ================= SIMPAN PERANGKAT =================
    public function storePerangkat(Request $request)
    {
        $request->validate([
            'jabatan' => 'required',
            'nama' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = [
            'jabatan' => $request->jabatan,
            'nama' => $request->nama,
        ];

        if ($request->hasFile('foto')) {

            $lama = DB::table('perangkat_desas')
                ->where('jabatan', $request->jabatan)
                ->first();

            if ($lama && $lama->foto) {
                $publicId = $this->getPublicId($lama->foto);
                Cloudinary::destroy($publicId);
            }

            $upload = Cloudinary::upload(
                $request->file('foto')->getRealPath()
            );

            $data['foto'] = $upload->getSecurePath();
        }

        $exists = DB::table('perangkat_desas')
            ->where('jabatan', $request->jabatan)
            ->exists();

        if ($exists) {
            DB::table('perangkat_desas')
                ->where('jabatan', $request->jabatan)
                ->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('perangkat_desas')->insert($data);
        }

        return back()->with('success', 'Data perangkat desa berhasil disimpan');
    }

    // ================= HELPER CLOUDINARY =================
    private function getPublicId($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        $filename = end($parts);
        return pathinfo($filename, PATHINFO_FILENAME);
    }
    public function uploadWallpaper(Request $request)
    {
        $request->validate([
            'wallpaper' => 'required|image|max:4096'
        ]);

        $file = $request->file('wallpaper');

        $destination = public_path('images/wallpaper');

        $filename = 'wallpaper_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destination, $filename);

        file_put_contents($destination . '/active.txt', $filename);

        return back()->with('success', 'Wallpaper berhasil ditambahkan & diaktifkan');
    }

    public function setWallpaper(Request $request)
    {
        $file = $request->file;

        $path = public_path('images/wallpaper/active.txt');

        file_put_contents($path, $file);

        return back()->with('success', 'Wallpaper berhasil diganti');
    }
    public function deleteWallpaper(Request $request)
    {
        $file = $request->file;

        $path = public_path('images/wallpaper/' . $file);
        $activePath = public_path('images/wallpaper/active.txt');

        // hapus file jika ada
        if (file_exists($path)) {
            unlink($path);
        }

        // jika yang dihapus adalah wallpaper aktif
        if (file_exists($activePath)) {
            $active = trim(file_get_contents($activePath));

            if ($active == $file) {
                file_put_contents($activePath, '');
            }
        }

        return back()->with('success', 'Wallpaper berhasil dihapus');
    }
}
