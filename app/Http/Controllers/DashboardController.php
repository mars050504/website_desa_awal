<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ================= ADMIN DASHBOARD =================
    public function index()
    {
        $totalWarga = DB::table('users')->count();
        $totalSurat = DB::table('surat')->count();
        $totalJenis = DB::table('jenis_surat')->count();
        $totalKriteria = DB::table('kriteria')->count();

        $grafik = DB::table('surat')
            ->selectRaw("DATE_FORMAT(tanggal,'%M') as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderByRaw("MIN(tanggal)")
            ->get();

        $prioritas = DB::table('surat')
            ->orderBy('tanggal', 'desc')
            ->limit(3)
            ->get();

        return view('admin.dashboard', compact(
            'totalWarga',
            'totalSurat',
            'totalJenis',
            'totalKriteria',
            'grafik',
            'prioritas'
        ));
    }


    // ================= WARGA DASHBOARD =================
    public function warga()
    {
        $berita = DB::table('berita')
            ->orderByDesc('id')
            ->limit(2)
            ->get();

        return view('warga.dashboard', compact('berita'));
    }
}