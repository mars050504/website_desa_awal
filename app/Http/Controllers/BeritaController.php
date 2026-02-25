<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = DB::table('berita')->orderByDesc('created_at')->get();
        return view('warga.berita.index', compact('berita'));
    }

    public function show($id)
    {
        $berita = DB::table('berita')->where('id', $id)->first();

        if (!$berita) {
            abort(404);
        }

        return view('warga.berita.show', compact('berita'));
    }
}
