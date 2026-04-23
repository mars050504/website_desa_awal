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
            top: 15px;
            width: 85px;
            height: 100px;
            background: transparent;
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
            font-style: italic;
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
        .teks {
            text-align: justify;
            text-indent: 0cm;
            margin-top: 10px;
            font-size: 12pt;
        }
        .paragraf {
            text-align: justify;
            text-indent: 1.25cm;
            margin-top: 10px;
            font-size: 12pt;
        }

        /* ================= DATA ================= */
        .data_atas{
            margin-top: 10px;
            margin-left: 2cm;
            font-size: 12pt;
        }
        .data_bawah{
            margin-top: 10px;
            margin-left: 0cm;
            font-size: 12pt;
        }

        .data td {
            padding: 2px 6px;
            vertical-align: top;
        }

        .label {
            width: 5cm;
        }

        /* ================= TTD ================= */
        .ttd {
            margin-top: 60px;
            text-align: right;
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

        <img src="{{ public_path('images/logo kelahiran.png') }}" class="logo">

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
        <b>SURAT KETERANGAN KELAHIRAN</b>
    </div>

    <div class="nomor">
        No : {{ $details['nomor'] }}/431.502.2.6/{{ $details['tahun'] }}
    </div>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Yang bertanda tangan dibawah ini Kepala Desa Bloro, Kecamatan Besuki Kabupaten Situbondo, menerangkan bahwa :
    </div>

    <!-- ================= DATA KELAHIRAN ================= -->
    <table class="data_atas">
        <tr>
            <td class="label">Hari</td>
            <td>: {{ $details['hari'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td> :
@php
    setlocale(LC_TIME, 'id_ID');
@endphp

{{ !empty($details['tanggal_lahir']) 
    ? strftime('%d %B %Y', strtotime($details['tanggal_lahir'])) 
    : '-' }}
</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>: {{ $details['pukul'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempat Kelahiran</td>
            <td>: {{ $details['tempat_lahir'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- ================= PARAGRAF ================= -->
    <div class="teks">
        Telah lahir seorang anak {{ $details['jenis_kelamin'] ?? '-' }} :
    </div>

    <table class="data_bawah">
        <tr>
            <td class="label">Bernama</td>
            <td>: <b>{{ $details['nama_bayi'] ?? '-' }}</b></td>
        </tr>
    </table>

    <div class="teks">
        Dari seorang 
    </div>

    <table class="data_bawah">
        <tr>
            <td class="label">Ibu</td>
            <td>: {{ $details['nama_ibu'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Ayah</td>
            <td>: {{ $details['nama_ayah'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $details['alamat'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- ================= PENUTUP ================= -->
    <div class="paragraf">
        Surat keterangan ini dibuat atas dasar yang sebenarnya.
    </div>

    <!-- ================= TTD ================= -->
    <div class="ttd">
        Situbondo, {{ $details['tanggal_surat'] }}<br>
        Kepala Desa Bloro<br><br><br><br>
        <span class="nama">EDY SUSIYANTO</span>
    </div>

</body>

</html>