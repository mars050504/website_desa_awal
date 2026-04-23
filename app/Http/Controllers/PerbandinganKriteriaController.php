<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerbandinganKriteriaController extends Controller
{
    // =============================
    // 1. FORM PERBANDINGAN
    // =============================
    public function index()
    {
        $kriteria = DB::table('kriteria')
            ->where('aktif', 1)
            ->orderBy('kode')
            ->get();

        return view('admin.perbandingan_kriteria.index', compact('kriteria'));
    }

    // =============================
    // 2. HITUNG AHP
    // =============================
    public function hitung(Request $request)
    {
        $kriteria = DB::table('kriteria')
            ->where('aktif', 1)
            ->orderBy('kode')
            ->get();

        $kode = $kriteria->pluck('kode')->toArray();

        // =============================
        // MATRKS
        // =============================
        $matriks = [];

        foreach ($kode as $i) {
            foreach ($kode as $j) {

                if ($i == $j) {
                    $matriks[$i][$j] = 1;
                } elseif (isset($request->nilai[$i][$j])) {
                    $matriks[$i][$j] = floatval($request->nilai[$i][$j]);
                    $matriks[$j][$i] = 1 / $matriks[$i][$j];
                }
            }
        }

        // =============================
        // TOTAL KOLOM
        // =============================
        $totalKolom = [];

        foreach ($kode as $j) {
            $totalKolom[$j] = 0;
            foreach ($kode as $i) {
                $totalKolom[$j] += $matriks[$i][$j];
            }
        }

        // =============================
        // NORMALISASI
        // =============================
        $normalisasi = [];

        foreach ($kode as $i) {
            foreach ($kode as $j) {
                $normalisasi[$i][$j] = $matriks[$i][$j] / $totalKolom[$j];
            }
        }

        // =============================
        // BOBOT
        // =============================
        $bobot = [];

        foreach ($kode as $i) {
            $bobot[$i] = array_sum($normalisasi[$i]) / count($kode);
        }

        // =============================
        // LAMBDA MAX
        // =============================
        $lambdaMax = 0;

        foreach ($kode as $i) {
            $total = 0;
            foreach ($kode as $j) {
                $total += $matriks[$i][$j] * $bobot[$j];
            }
            $lambdaMax += $total / $bobot[$i];
        }

        $lambdaMax = $lambdaMax / count($kode);

        // =============================
        // CI & CR
        // =============================
        $n = count($kode);

        $CI = ($lambdaMax - $n) / ($n - 1);

        $RI_table = [
            1 => 0.00,
            2 => 0.00,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49
        ];

        $RI = $RI_table[$n] ?? 0;
        $CR = $RI != 0 ? $CI / $RI : 0;

        // =============================
        // SIMPAN LOG KE DATABASE
        // =============================
        DB::table('ahp_kriteria_log')->insert([
            'tanggal' => now(),
            'matriks' => json_encode($matriks),
            'normalisasi' => json_encode($normalisasi),
            'bobot' => json_encode($bobot),
            'lambda_max' => $lambdaMax,
            'ci' => $CI,
            'cr' => $CR
        ]);

        // =============================
        // FORMAT TAMPILAN
        // =============================
        $matriksTampil = [];

        foreach ($kode as $i) {
            foreach ($kode as $j) {
                $matriksTampil[$i][$j] = number_format($matriks[$i][$j], 3);
            }
        }

        return view('admin.perbandingan_kriteria.hasil', [
            'kode' => $kode,
            'matriksTampil' => $matriksTampil,
            'normalisasi' => $normalisasi,
            'bobot' => $bobot,
            'lambdaMax' => $lambdaMax,
            'CI' => $CI,
            'CR' => $CR
        ]);
    }

    // =============================
    // 3. SIMPAN BOBOT KE KRITERIA
    // =============================
    public function simpanBobot(Request $request)
    {
        $bobot = $request->bobot;

        foreach ($bobot as $kode => $nilai) {
            DB::table('kriteria')
                ->where('kode', $kode)
                ->update([
                    'bobot' => $nilai
                ]);
        }

        return redirect('/kriteria')->with('success', 'Bobot berhasil disimpan');
    }

    // =============================
    // 4. HASIL TERAKHIR (FULL)
    // =============================
    public function hasilTerakhir()
    {
        $data = DB::table('ahp_kriteria_log')
            ->orderBy('tanggal', 'desc')
            ->first();

        if (!$data) {
            return redirect('/kriteria')->with('error', 'Belum ada perhitungan AHP');
        }

        // =============================
        // Decode JSON
        // =============================
        $matriksRaw = json_decode($data->matriks, true);
        $normalisasiRaw = json_decode($data->normalisasi, true);
        $bobotRaw = json_decode($data->bobot, true);

        // =============================
        // Format Matriks (3 desimal)
        // =============================
        $matriksTampil = [];

        foreach ($matriksRaw as $i => $row) {
            foreach ($row as $j => $value) {
                $matriksTampil[$i][$j] = number_format($value, 3);
            }
        }

        // =============================
        // Format Normalisasi (3 desimal)
        // =============================
        $normalisasi = [];

        foreach ($normalisasiRaw as $i => $row) {
            foreach ($row as $j => $value) {
                $normalisasi[$i][$j] = number_format($value, 3);
            }
        }

        // =============================
        // Format Bobot (4 desimal)
        // =============================
        $bobot = [];

        foreach ($bobotRaw as $k => $v) {
            $bobot[$k] = number_format($v, 4);
        }

        return view('admin.perbandingan_kriteria.hasil', [
            'kode' => array_keys($bobotRaw),
            'matriksTampil' => $matriksTampil,
            'normalisasi' => $normalisasi,
            'bobot' => $bobot,
            'lambdaMax' => number_format($data->lambda_max, 4),
            'CI' => number_format($data->ci, 4),
            'CR' => number_format($data->cr, 4)
        ]);
    }
}
