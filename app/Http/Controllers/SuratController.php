<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SuratController extends Controller
{
    // ================= RIWAYAT =================
    public function riwayat()
    {
        $surat = DB::table('surat')
            ->join('jenis_surat', 'surat.jenis', '=', 'jenis_surat.id')
            ->select('surat.*', 'jenis_surat.nama_jenis')
            ->where('surat.user_id', auth()->id())
            ->orderByDesc('surat.id')
            ->get();

        return view('warga.riwayat-surat', compact('surat'));
    }

    // ================= FORM AJUKAN =================
    public function create()
    {
        $jenisSurat = DB::table('jenis_surat')->get();
        return view('warga.ajukan', compact('jenisSurat'));
    }

    // ================= FORM DINAMIS =================
    public function getForm($id)
    {
        $jenis = DB::table('jenis_surat')->where('id', $id)->first();

        if (!$jenis) abort(404);

        return view('warga.partials.form_' . $jenis->slug);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
        ]);

        $suratId = DB::table('surat')->insertGetId([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'tanggal' => now(),
            'status' => 'Diproses'
        ]);

        // FILE
        foreach (['dok_ktp','dok_kk','dok_pengantar'] as $file) {
            if ($request->hasFile($file)) {
                $upload = Cloudinary::uploadFile(
                    $request->file($file)->getRealPath(),
                    ["resource_type" => "raw"]
                );

                DB::table('surat')->where('id',$suratId)->update([
                    $file => $upload->getSecurePath()
                ]);
            }
        }

        // DETAIL
        foreach ($request->except([
            '_token','nama','jenis','dok_ktp','dok_kk','dok_pengantar'
        ]) as $key => $value) {

            if ($value !== null && $value !== '') {
                DB::table('surat_detail')->insert([
                    'surat_id' => $suratId,
                    'field_name' => $key,
                    'value' => $value
                ]);
            }
        }

        return redirect('/riwayat-surat')->with('success','Pengajuan berhasil');
    }

    // ================= EDIT (DETAIL + DATA) =================
    public function edit($id)
    {
        $surat = DB::table('surat')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$surat) abort(404);

        $details = DB::table('surat_detail')
            ->where('surat_id', $id)
            ->pluck('value','field_name')
            ->toArray();

        return view('warga.edit', compact('surat','details'));
    }

    // ================= UPDATE (FILE + DATA) =================
    public function update(Request $request, $id)
{
    $data = [];

    // FILE
    foreach (['dok_ktp','dok_kk','dok_pengantar'] as $file) {
        if ($request->hasFile($file)) {
            $upload = Cloudinary::uploadFile(
                $request->file($file)->getRealPath(),
                ["resource_type" => "raw"]
            );

            $data[$file] = $upload->getSecurePath();
        }
    }

    // ⛔ CEGAH UPDATE KOSONG
    if (!empty($data)) {
        DB::table('surat')
            ->where('id',$id)
            ->where('user_id',auth()->id())
            ->update($data);
    }

    // DATA DINAMIS
    foreach ($request->except([
        '_token',
        '_method',
        'dok_ktp',
        'dok_kk',
        'dok_pengantar'
    ]) as $field => $value) {

        if ($value !== null && $value !== '') {
            DB::table('surat_detail')->updateOrInsert(
                ['surat_id'=>$id,'field_name'=>$field],
                ['value'=>$value]
            );
        }
    }

    return redirect('/riwayat-surat')
        ->with('success','Data berhasil diperbarui');
}

    // ================= DELETE =================
    public function destroy($id)
    {
        DB::table('surat')
            ->where('id',$id)
            ->where('user_id',auth()->id())
            ->delete();

        return redirect('/riwayat-surat')->with('success','Data dihapus');
    }
}
