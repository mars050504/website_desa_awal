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
            padding-top: 10px;
        }

        .logo {
            position: absolute;
            left: 12px;
            top: 0;
            width: 85px;
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
        }

        /* ================= TABEL ================= */
        .tabel {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12pt;
        }

        .tabel th,
        .tabel td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        /* ================= DATA BAWAH ================= */
        .data-bawah {
            margin-top: 10px;
            margin-left: 2.5cm;
            font-size: 12pt;
        }

        .data-bawah td {
            padding: 2px 6px;
            vertical-align: top;
        }

        .label {
            width: 5cm;
        }

        /* ================= TTD ================= */
        .ttd {
            margin-top: 60px;
            width: 100%;
        }

        .ttd-kiri {
            float: left;
            text-align: center;
            width: 45%;
        }

        .ttd-kanan {
            float: right;
            text-align: center;
            width: 45%;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .clear {
            clear: both;
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
        <b>SURAT KETERANGAN KEHILANGAN</b>
    </div>

    <div class="nomor">
        Nomor : 593.2/{{ $details['nomor'] }}/431.502.2.6/{{ $details['tahun'] }}
    </div>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        1. Yang bertanda tangan dibawah ini&nbsp;&nbsp;&nbsp;&nbsp; :
     </div>

    <table class="data-bawah">
        <tr>
            <td class="label">a. Nama Lengkap</td>
            <td>: <strong>EDY SUSIYANTO</strong> </td>
        </tr>
        <tr>
            <td>b. Jabatan</td>
            <td>: Kepala Desa Bloro</td>
        </tr>
    </table>

    <div class="paragraf">
        Dengan ini menerangkan bahwa :
    </div>

    <!-- ================= TABEL ================= -->
    <table class="tabel">
        <tr>
            <th>NO</th>
            <th>NIK</th>
            <th>NAMA LENGKAP</th>
            <th>JENIS KELAMIN</th>
            <th>TEMPAT LAHIR</th>
            <th>TANGGAL LAHIR</th>
        </tr>
        <tr>
            <td>1</td>
            <td>{{ $details['nik'] ?? '-' }}</td>
            <td>{{ $details['nama_lengkap'] ?? '-' }}</td>
            <td>{{ $details['jenis_kelamin'] ?? '-' }}</td>
            <td>{{ $details['tempat_lahir'] ?? '-' }}</td>
            <td>
                {{ !empty($details['tanggal_lahir']) 
    ? date('d-m-Y', strtotime($details['tanggal_lahir'])) 
    : '-' }}
            </td>
        </tr>
    </table>

    <!-- ================= DATA BAWAH ================= -->
    <table class="data-bawah">
        <tr>
            <td class="label">Pekerjaan</td>
            <td>: {{ $details['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $details['alamat'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>: {{ $details['keterangan_kehilangan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>: <strong> {{ $details['keperluan'] ?? '-' }}</strong></td>
        </tr>
    </table>

    <!-- ================= PENUTUP ================= -->
    <div class="paragraf">
        Berhubung maksud yang bersangkutan, diminta agar yang berwenang memberikan bantuan serta fasilitas seperlunya.
    </div>

    <div class="paragraf">
        Demikian Surat Keterangan Kehilangan ini dibuat untuk dipergunakan sebagaimana mestinya.
    </div>

    <!-- ================= TTD ================= -->
    <div class="ttd">
        <div class="ttd-kiri">
            Pelapor<br><br><br><br><br>
            <span class="nama">{{ $details['nama_pelapor'] ?? '-' }}</span>
        </div>

        <div class="ttd-kanan">
            Bloro, {{ $details['tanggal_surat'] }}<br>
            Kepala Desa Bloro<br><br><br><br>
            <span class="nama">EDY SUSIYANTO</span>
        </div>
    </div>

    <div class="clear"></div>

</body>

</html>