<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    // ================= FORMAT TANGGAL =================
    private function formatTanggal($value)
    {
        if (!$value) return '-';

        try {
            return Carbon::createFromFormat('d-m-Y', $value)->format('d-m-Y');
        } catch (\Exception $e) {
            try {
                return Carbon::parse($value)->format('d-m-Y');
            } catch (\Exception $e) {
                return $value;
            }
        }
    }

    // ================= BUILD TTL =================
    private function buildTTL($tempat, $tanggal)
    {
        $tempat = trim($tempat ?? '');
        $tanggal = $this->formatTanggal($tanggal);

        $parts = array_unique(array_map('trim', explode(',', $tempat)));
        $tempat = $parts[0] ?? $tempat;

        if ($tempat && $tanggal && $tanggal != '-') {
            return $tempat . ', ' . $tanggal;
        }

        return '-';
    }

    // ================= LIST =================
    public function index(Request $request)
    {
        $query = DB::table('surat')
            ->join('jenis_surat', 'surat.jenis', '=', 'jenis_surat.id')
            ->select('surat.*', 'jenis_surat.nama_jenis');

        if ($request->nama) {
            $query->where('surat.nama', 'like', '%' . $request->nama . '%');
        }

        $surats = $query->orderBy('surat.id', 'desc')->get();

        return view('admin.surat', compact('surats'));
    }

    // ================= DETAIL =================
    public function show($id)
{
    // ================= AMBIL SURAT =================
    $surat = \App\Models\Surat::with('user')->findOrFail($id);

    // ================= AMBIL JENIS SURAT =================
    $jenis = DB::table('jenis_surat')->where('id', $surat->jenis)->first();

    // 🔥 JIKA JENIS TIDAK ADA → JANGAN CRASH
    if (!$jenis) {
        $jenis = (object)[
            'template_text' => '',
            'nama_jenis' => 'Tidak Diketahui'
        ];
    }

    // ================= AMBIL DETAIL =================
    $details = DB::table('surat_detail')
        ->where('surat_id', $id)
        ->pluck('value', 'field_name')
        ->toArray();

    // ================= TTL =================
    $ttl = $this->buildTTL(
        $details['tempat_lahir'] ?? null,
        $details['tanggal_lahir'] ?? null
    );

    $details['ttl'] = $ttl;
    $details['tanggal_surat'] = Carbon::now()->translatedFormat('d F Y');

    // ================= NOMOR =================
    $details['nomor'] = $details['nomor'] ?? str_pad($surat->id, 3, '0', STR_PAD_LEFT);
    $details['tahun'] = date('Y');

    // ================= TEMPLATE =================
    $template = $jenis->template_text ?? '';

    foreach ($details as $key => $value) {
        $template = str_replace('{{' . $key . '}}', $value ?? '-', $template);
    }

    // ================= NAMA =================
    $template = str_replace('{{nama}}', $surat->nama ?? '-', $template);

    // ================= ISI =================
    $isi = $surat->isi_surat ?? $template ?? '';

    // ================= FIX TTL =================
    if (!empty($isi)) {
        $isi = preg_replace(
            '/Tempat\s*&\s*Tgl\s*Lahir\s*:\s*.*/i',
            'Tempat & Tgl Lahir  : ' . $ttl,
            $isi
        );
    }

    // ================= RETURN VIEW =================
    return view('admin.surat.detail', compact('surat', 'isi'));
}

    // ================= UPDATE STATUS =================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Selesai,Ditolak',
            'keterangan' => 'nullable|string'
        ]);

        DB::table('surat')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);

        return back()->with('success', 'Status diperbarui');
    }

    // ================= UPDATE ISI =================
    public function updateIsi(Request $request, $id)
    {
        $isi = $request->isi;

        // ================= SIMPAN ISI =================
        DB::table('surat')
            ->where('id', $id)
            ->update([
                'isi_surat' => $isi
            ]);

        // ================= PARSING FIELD =================
        $fields = [
            'nama' => 'Nama',
            'nik' => 'NIK',
            'jenis_kelamin' => 'Jenis Kelamin',
            'kewarganegaraan' => 'Kewarganegaraan',
            'kebangsaan' => 'Kebangsaan',
            'agama' => 'Agama',
            'status' => 'Status',
            'pekerjaan' => 'Pekerjaan',
            'alamat' => 'Alamat',
            'keterangan' => 'Keterangan',
            'keperluan' => 'Keperluan',
            'pendidikan' => 'Pendidikan',
            'hari' => 'Hari',
            'tanggal_meninggal' => 'Tanggal',
            'jam' => 'Jam',
            'tempat_meninggal' => 'Tempat',
            'nama_pelapor' => 'Pelapor',

        ];

        foreach ($fields as $key => $label) {

            preg_match('/^' . preg_quote($label, '/') . '\s*:\s*(.+)$/mi', $isi, $match);

            if (!empty($match[1])) {
                DB::table('surat_detail')->updateOrInsert(
                    [
                        'surat_id' => $id,
                        'field_name' => $key
                    ],
                    [
                        'value' => trim($match[1])
                    ]
                );
            }
        }

        // ================= PARSING NOMOR (DARI No.Reg) =================
        preg_match('/Nomor\s*:\s*(?:\d+\/)?(.*?)\/431/i', $isi, $matchNomor);
        if (!empty($matchNomor[1])) {
            DB::table('surat_detail')->updateOrInsert(
                [
                    'surat_id' => $id,
                    'field_name' => 'nomor'
                ],
                [
                    'value' => trim($matchNomor[1])
                ]
            );
        }

        // ================= TTL =================
        preg_match('/Tempat\s*&\s*Tgl\s*Lahir\s*:\s*(.*)/i', $isi, $matchTTL);

        if (!empty($matchTTL[1])) {

            $value = trim($matchTTL[1]);

            $parts = array_map('trim', explode(',', $value));

            $tanggal = end($parts);
            $tempat = implode(', ', array_slice($parts, 0, -1));

            DB::table('surat_detail')->updateOrInsert(
                [
                    'surat_id' => $id,
                    'field_name' => 'tempat_lahir'
                ],
                [
                    'value' => $tempat
                ]
            );

            DB::table('surat_detail')->updateOrInsert(
                [
                    'surat_id' => $id,
                    'field_name' => 'tanggal_lahir'
                ],
                [
                    'value' => $tanggal
                ]
            );
        }

        return back()->with('success', 'Isi surat diperbarui');
    }
    // ================= PDF =================
    public function pdf($id)
    {
        $surat = DB::table('surat')->where('id', $id)->first();
        if (!$surat) abort(404);

        $jenis = DB::table('jenis_surat')->where('id', $surat->jenis)->first();

        $details = DB::table('surat_detail')
            ->where('surat_id', $id)
            ->pluck('value', 'field_name')
            ->toArray();

        $ttl = $this->buildTTL(
            $details['tempat_lahir'] ?? null,
            $details['tanggal_lahir'] ?? null
        );

        $details['ttl'] = $ttl;
        $details['tanggal_surat'] = Carbon::now()->translatedFormat('d F Y');

        // 🔥 NOMOR BISA EDIT DI PDF
        $details['nomor'] = $details['nomor'] ?? str_pad($surat->id, 3, '0', STR_PAD_LEFT);
        $details['tahun'] = date('Y');

        $template = $jenis->template_text;

        foreach ($details as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $template = str_replace('{{nama}}', $surat->nama, $template);

        $isi = $surat->isi_surat ?? $template;

        // 🔥 FIX TTL
        $isi = preg_replace(
            '/Tempat\s*&\s*Tgl\s*Lahir\s*:\s*.*/i',
            'Tempat & Tgl Lahir  : ' . $ttl,
            $isi
        );

        $view = 'admin.surat.pdf.' . $jenis->slug;

        return Pdf::loadView($view, [
            'isi' => $isi,
            'surat' => $surat,
            'details' => $details
        ])->stream('surat.pdf');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        DB::table('surat')->where('id', $id)->delete();

        return redirect('/kelola-surat')->with('success', 'Surat dihapus');
    }
    public function rekap(Request $request)
    {
        // ================= REKAP BULANAN =================
        $rekapBulanan = DB::table('surat')
            ->select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan', 'desc')
            ->get();

        // ================= DATA SURAT PER BULAN =================
        $surats = [];

        if ($request->bulan) {
            $surats = DB::table('surat')
                ->join('jenis_surat', 'surat.jenis', '=', 'jenis_surat.id')
                ->select('surat.*', 'jenis_surat.nama_jenis')
                ->where(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"), $request->bulan)
                ->orderBy('surat.tanggal', 'desc')
                ->get();
        }

        return view('admin.surat.rekap', compact('rekapBulanan', 'surats'));
    }
    public function exportCsv(Request $request)
    {
        $bulan = $request->bulan;

        $surats = DB::table('surat')
            ->join('jenis_surat', 'surat.jenis', '=', 'jenis_surat.id')
            ->select('surat.nama', 'jenis_surat.nama_jenis', 'surat.tanggal', 'surat.status')
            ->when($bulan, function ($q) use ($bulan) {
                $q->whereRaw("DATE_FORMAT(surat.tanggal, '%Y-%m') = ?", [$bulan]);
            })
            ->get();

        $fileName = "rekap-surat-$bulan.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($surats) {
            $file = fopen('php://output', 'w');

            // header kolom
            fputcsv($file, ['Nama', 'Jenis', 'Tanggal', 'Status']);

            // isi data
            foreach ($surats as $s) {
                fputcsv($file, [
                    $s->nama,
                    $s->nama_jenis,
                    \Carbon\Carbon::parse($s->tanggal)->format('d-m-Y'),
                    $s->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
