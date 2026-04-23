<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AhpController extends Controller
{
    // =====================================================
    // 🔥 PRIORITAS SURAT (REAL DATA)
    // =====================================================
    public function prioritas()
    {
        // =============================
        // 1. Ambil Bobot Kriteria
        // =============================
        $kriteria = DB::table('kriteria')
            ->where('aktif', 1)
            ->get()
            ->keyBy('kode');

        // =============================
        // 2. Ambil Data Surat
        // =============================
        $surats = DB::table('surat')
            ->leftJoin('jenis_surat', 'surat.jenis', '=', 'jenis_surat.id')
            ->select('surat.*', 'jenis_surat.nama_jenis', 'jenis_surat.urgensi')
            ->where('surat.status', 'Diproses')
            ->get();

        $hasil = [];
        $bobotValues = $kriteria->pluck('bobot')->toArray();
        $semuaSama = count(array_unique($bobotValues)) === 1;

        foreach ($surats as $s) {

            if ($semuaSama) {

                // =============================
                // OVERRIDE: SEMUA NILAI SAMA
                // =============================
                $nilaiC1 = 1;
                $nilaiC2 = 1;
                $nilaiC3 = 1;
                $nilaiC4 = 1;
            } else {

                // =============================
                // NORMAL (LOGIKA ASLI)
                // =============================

                // C1
                $hari = Carbon::now()->diffInDays(Carbon::parse($s->tanggal));
                $nilaiC1 = ($hari >= 7) ? 1 : (($hari >= 3) ? 0.7 : 0.4);

                // C2
                $lengkap = ($s->dok_ktp && $s->dok_kk && $s->dok_pengantar);
                $nilaiC2 = $lengkap ? 1 : 0.2;

                // C3
                if ($s->urgensi == 'Mendesak') {
                    $nilaiC3 = 1;
                } elseif ($s->urgensi == 'Tergolong Menengah') {
                    $nilaiC3 = 0.7;
                } else {
                    $nilaiC3 = 0.4;
                }

                // C4
                $jumlah = DB::table('surat')
                    ->where('user_id', $s->user_id)
                    ->count();

                $nilaiC4 = ($jumlah >= 5) ? 1 : (($jumlah >= 3) ? 0.7 : 0.4);
            }

            // =============================
            // HITUNG NILAI
            // =============================
            $Pi =
                ($nilaiC1 * ($kriteria['C1']->bobot ?? 0)) +
                ($nilaiC2 * ($kriteria['C2']->bobot ?? 0)) +
                ($nilaiC3 * ($kriteria['C3']->bobot ?? 0)) +
                ($nilaiC4 * ($kriteria['C4']->bobot ?? 0));

            $hasil[] = [
                'surat' => $s,
                'nilai' => round($Pi, 4),
                'ranking' => 0
            ];
        }

        // =============================
        // SORTING RANKING
        // =============================
        usort($hasil, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        foreach ($hasil as $i => $h) {
            $hasil[$i]['ranking'] = $i + 1;
        }

        return view('admin.ahp.prioritas', compact('hasil'));
    }

    // =====================================================
    // 🔥 MATRKS ALTERNATIF (FORMAL AHP)
    // =====================================================
    public function matriksAlternatif()
    {
        $jenisSurat = DB::table('jenis_surat')->get();

        $matrixAlternatif = [];

        foreach ($jenisSurat as $j) {

            // Semua sama kecuali urgensi
            $c1 = 1;
            $c2 = 1;
            $c4 = 1;

            if ($j->urgensi == 'Mendesak') {
                $c3 = 1;
            } elseif ($j->urgensi == 'Tergolong Menengah') {
                $c3 = 0.7;
            } else {
                $c3 = 0.4;
            }

            $matrixAlternatif[] = [
                'nama' => $j->nama_jenis,
                'C1' => $c1,
                'C2' => $c2,
                'C3' => $c3,
                'C4' => $c4,
            ];
        }

        // Normalisasi
        $maxC1 = max(array_column($matrixAlternatif, 'C1'));
        $maxC2 = max(array_column($matrixAlternatif, 'C2'));
        $maxC3 = max(array_column($matrixAlternatif, 'C3'));
        $maxC4 = max(array_column($matrixAlternatif, 'C4'));

        $matrixNormalisasi = [];

        foreach ($matrixAlternatif as $row) {
            $matrixNormalisasi[] = [
                'nama' => $row['nama'],
                'C1' => $row['C1'] / $maxC1,
                'C2' => $row['C2'] / $maxC2,
                'C3' => $row['C3'] / $maxC3,
                'C4' => $row['C4'] / $maxC4,
            ];
        }

        return view('admin.ahp.matriks_alternatif', compact(
            'matrixAlternatif',
            'matrixNormalisasi'
        ));
    }

    // =====================================================
    // 🔥 PRIORITAS GLOBAL (UNTUK ANALISIS)
    // =====================================================
    public function prioritasGlobal()
    {
        $kriteria = DB::table('kriteria')
            ->where('aktif', 1)
            ->get()
            ->keyBy('kode');

        $jenisSurat = DB::table('jenis_surat')->get();

        $hasil = [];

        foreach ($jenisSurat as $j) {

            $c1 = 1;
            $c2 = 1;
            $c4 = 1;

            if ($j->urgensi == 'Mendesak') {
                $c3 = 1;
            } elseif ($j->urgensi == 'Tergolong Menengah') {
                $c3 = 0.7;
            } else {
                $c3 = 0.4;
            }

            $v1 = $c1 * ($kriteria['C1']->bobot ?? 0);
            $v2 = $c2 * ($kriteria['C2']->bobot ?? 0);
            $v3 = $c3 * ($kriteria['C3']->bobot ?? 0);
            $v4 = $c4 * ($kriteria['C4']->bobot ?? 0);

            $total = $v1 + $v2 + $v3 + $v4;

            $hasil[] = [
                'nama' => $j->nama_jenis,
                'c1' => $c1,
                'c2' => $c2,
                'c3' => $c3,
                'c4' => $c4,
                'v1' => $v1,
                'v2' => $v2,
                'v3' => $v3,
                'v4' => $v4,
                'nilai' => round($total, 4),
                'ranking' => 0
            ];
        }

        usort($hasil, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

        foreach ($hasil as $i => $h) {
            $hasil[$i]['ranking'] = $i + 1;
        }

        return view('admin.ahp.prioritas_global', compact('hasil'));
    }
}
