<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerbandinganKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = DB::table('kriteria')->orderBy('kode')->get();
        return view('admin.perbandingan_kriteria.index', compact('kriteria'));
    }

    public function hitung(Request $request)
    {
        $kriteria = DB::table('kriteria')->orderBy('kode')->get();
        $kode = $kriteria->pluck('kode')->toArray();
        $n = count($kode);

        $matriksHitung = [];
        $matriksTampil = [];

        foreach ($kode as $i) {
            foreach ($kode as $j) {

                if ($i == $j) {
                    $matriksHitung[$i][$j] = 1;
                    $matriksTampil[$i][$j] = '1';
                    continue;
                }

                $key1 = $i.'-'.$j;
                $key2 = $j.'-'.$i;

                // INPUT LANGSUNG
                if (isset($request->nilai[$key1])) {
                    $input = $request->nilai[$key1]; // contoh "1/3"
                    $matriksTampil[$i][$j] = $input;
                }
                // INPUT KEBALIKAN
                elseif (isset($request->nilai[$key2])) {
                    $input = $request->nilai[$key2]; // contoh "1/3"
                    if (str_contains($input, '/')) {
                        [$a,$b] = explode('/',$input);
                        $matriksTampil[$i][$j] = $b/$a; // jadi 3
                    } else {
                        $matriksTampil[$i][$j] = '1/'.$input;
                    }
                }
                else {
                    $input = 1;
                    $matriksTampil[$i][$j] = '1';
                }

                // KONVERSI KE ANGKA
                if (str_contains($input,'/')) {
                    [$a,$b] = explode('/',$input);
                    $nilai = $a/$b;
                } else {
                    $nilai = (float)$input;
                }

                if (isset($request->nilai[$key2]) && !isset($request->nilai[$key1])) {
                    $nilai = 1/$nilai;
                }

                $matriksHitung[$i][$j] = $nilai;
            }
        }

        foreach ($kode as $j) {
            $totalKolom[$j] = array_sum(array_column($matriksHitung,$j));
        }

        foreach ($kode as $i) {
            $totalBaris = 0;
            foreach ($kode as $j) {
                $normalisasi[$i][$j] = $matriksHitung[$i][$j] / $totalKolom[$j];
                $totalBaris += $normalisasi[$i][$j];
            }
            $bobot[$i] = $totalBaris / $n;
        }

        foreach ($bobot as $k=>$v) {
            DB::table('kriteria')->where('kode',$k)
                ->update(['bobot'=>round($v,4)]);
        }

        return view('admin.perbandingan_kriteria.hasil',
            compact('kode','matriksTampil','normalisasi','bobot'));
    }
}
