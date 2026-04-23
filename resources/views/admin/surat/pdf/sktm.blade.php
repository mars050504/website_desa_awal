<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: legal;
            margin-top: 1.6cm;
            margin-bottom: 1.27cm;
            margin-left: 2.2cm;
            margin-right: 2cm;
        }

        body {
            font-family: "Times New Roman";
            font-size: 12pt;
            line-height: 1.5;
        }

        /* ================= HEADER ================= */
        .header {
            position: relative;
            text-align: center;
        }

        .logo {
            position: absolute;
            left: 10px;
            top: 2px;
            width: 80px;
            height: auto;
        }

        .header-text h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            line-height: 1.2;
        }

        .header-text h2 {
            margin: 0;
            font-size: 22pt;
            font-weight: bold;
            line-height: 1.2;
        }

        .header-text p {
            margin: 0;
            font-size: 12pt;
            line-height: 1.2;
            font-weight: bold;
        }

        .line-thin {
            border-top: 1px solid black;
            margin-top: 8px;
        }

        .line-bold {
            border-top: 3px solid black;
            margin-top: 2px;
            margin-bottom: 18px;
        }

        /* ================= JUDUL ================= */
        .judul {
            text-align: center;
        }

        .judul b {
            text-decoration: underline;
            font-size: 16pt;
        }

        .nomor {
            text-align: center;
            font-size: 12pt;
            margin-top: 4px;
        }

        /* ================= PARAGRAF ================= */
        .paragraf {
            text-align: justify;
            text-indent: 1.25cm;
            margin-top: 10px;
            font-size: 12pt;
        }

        /* ================= DATA ================= */
        .data {
            margin-top: 10px;
            margin-left: 3cm;
            width: 83%;
            font-size: 12pt;
        }

        .data td {
            padding: 2px 6px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 12pt;
        }

        .label {
            width: 5cm;
        }

        .keterangan {
            text-align: justify;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            font-size: 12pt;
        }

        .ttd {
            margin-top: 60px;
            width: 200px;
            /* 🔥 batasi area */
            margin-left: auto;
            /* 🔥 dorong ke kanan */
            text-align: center;
            /* 🔥 isi jadi tengah */
            font-size: 12pt;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- ================= HEADER ================= -->
    <div class="header">

        <img src="{{ public_path('images/logo surat.jpg') }}" class="logo">

        <div class="header-text">
            <h1>PEMERINTAH KABUPATEN SITUBONDO</h1>
            <h1>KECAMATAN BESUKI</h1>
            <h2>DESA BLORO</h2>
            <p>Jl. Jatibanteng No. 06 Bloro Kode Pos 68356</p>
        </div>

        <div class="line-thin"></div>
        <div class="line-bold"></div>

    </div>

    <!-- ================= JUDUL ================= -->
    <div class="judul">
        <b>SURAT KETERANGAN TIDAK MAMPU</b>
    </div>

    <div class="nomor">
        Nomor Reg. :{{ $details['nomor'] }}/431.502.2.6/{{ $details['tahun'] }}
    </div>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Yang bertanda tangan dibawah ini kami Kepala Desa Bloro Kecamatan Besuki Kabupaten Situbondo, menerangkan dengan sebenarnya bahwa :
    </div>

    <!-- ================= DATA ================= -->
    <table class="data">
        <tr>
            <td class="label">Nama</td>
            <td>: <strong>{{ $details['nama'] ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $details['nik'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $details['jenis_kelamin'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tgl. Lahir</td>
            <td>: {{ $details['ttl'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td>: {{ $details['status'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $details['agama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $details['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $details['alamat'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Keterangan</td>
            <td class="keterangan">
                : {{ $details['keterangan'] ?? 'Bahwa nama tersebut adalah benar warga Desa Bloro Kecamatan Besuki Kabupaten Situbondo, dan berdasarkan data yang ada di kantor desa yang bersangkutan benar-benar berasal dari keluarga tidak mampu (Prasejahtera) dan tidak mempunyai penghasilan tetap perbulan.' }}
            </td>
        </tr>
    </table>

    <!-- ================= PENUTUP ================= -->
    <div class="paragraf">
        Demikian surat keterangan ini kami buat dengan sebenarnya dan untuk dipergunakan sebagaimana mestinya.
    </div>

    <!-- ================= TTD ================= -->
    <div class="ttd">
        Situbondo, {{ $details['tanggal_surat'] }}<br>
        Kepala Desa Bloro<br><br><br><br>
        <span class="nama">EDY SUSIYANTO</span>
    </div>

</body>

</html>