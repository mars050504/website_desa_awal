<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AhpController extends Controller
{
    public function prioritas()
    {
        // ================= AMBIL DATA KRITERIA =================
        $kriteria = DB::table('kriteria')
            ->get()
            ->keyBy('kode');

        // ================= AMBIL DATA SURAT =================
        $surats = DB::table('surat')
            ->join('jenis_surat', 'surat.jenis', '=', 'jenis_surat.nama_jenis')
            ->select('surat.*', 'jenis_surat.urgensi')
            ->get();

        $hasil = [];

        foreach ($surats as $s) {

            // ================= C1 - URGENSI =================
            if ($s->urgensi == 'Mendesak') {
                $c1 = 5;
            } elseif ($s->urgensi == 'Tergolong Menengah') {
                $c1 = 3;
            } else {
                $c1 = 1;
            }

            // ================= C2 - KELENGKAPAN DOKUMEN =================
            $lengkap = ($s->dok_ktp && $s->dok_kk && $s->dok_pengantar);
            $c2 = $lengkap ? 5 : 2;

            // ================= C3 - LAMA MENUNGGU =================
            $tanggal = Carbon::parse($s->tanggal);
            $hari = Carbon::now()->diffInDays($tanggal);

            if ($hari > 7) {
                $c3 = 5;
            } elseif ($hari > 3) {
                $c3 = 3;
            } else {
                $c3 = 1;
            }

            // ================= AMBIL BOBOT KRITERIA =================
            $bobotC1 = isset($kriteria['C1']) ? $kriteria['C1']->bobot : 0;
            $bobotC2 = isset($kriteria['C2']) ? $kriteria['C2']->bobot : 0;
            $bobotC3 = isset($kriteria['C3']) ? $kriteria['C3']->bobot : 0;

            // ================= HITUNG NILAI AKHIR =================
            $nilai = ($c1 * $bobotC1) +
                     ($c2 * $bobotC2) +
                     ($c3 * $bobotC3);

            $hasil[] = [
                'ranking' => 0, // sementara
                'nilai'   => round($nilai, 4),
                'surat'   => $s, // kirim object surat lengkap
            ];
        }

        // ================= URUTKAN NILAI TERTINGGI =================
        usort($hasil, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        // ================= BERIKAN RANKING =================
        foreach ($hasil as $index => $item) {
            $hasil[$index]['ranking'] = $index + 1;
        }

        return view('admin.ahp.prioritas', compact('hasil'));
    }
}