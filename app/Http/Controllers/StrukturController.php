<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StrukturController extends Controller
{
    public function index()
    {
        $perangkat = DB::table('perangkat_desas')
            ->get()
            ->keyBy('jabatan');

        return view('warga.struktur_pemerintahan', compact('perangkat'));
    }
}