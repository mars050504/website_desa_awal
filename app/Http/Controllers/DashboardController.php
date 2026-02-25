<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ADMIN
        if (auth()->user()->role === 'admin') {
            $surat = DB::table('surat')
                ->orderBy('tanggal', 'desc')
                ->get();

            return view('admin.dashboard', compact('surat'));
        }

        // WARGA
        $surat = DB::table('surat')
            ->where('user_id', auth()->user()->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('warga.dashboard', compact('surat'));
    }
}
