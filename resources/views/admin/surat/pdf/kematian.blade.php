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
            left: 10px;
            top: 0;
            width: 85px;
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
            font-weight: bold;
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
        }

        /* ================= PARAGRAF ================= */
        .paragraf {
            text-align: justify;
            text-indent: 1.25cm;
            margin-top: 10px;
        }

        /* ================= DATA ================= */
        .data {
            margin-top: 10px;
            margin-left: 2.5cm;
            width: 90%;
        }

        .data td {
            padding: 1px 2px;
            vertical-align: top;
        }

        .label {
            width: 3.5cm;
        }

        /* ================= TTD ================= */
        .ttd {
            margin-top: 60px;
            width: 100%;
        }

        .ttd-kiri {
            float: left;
            width: 45%;
            text-align: center;
        }

        .ttd-kanan {
            float: right;
            width: 45%;
            text-align: center;
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
            <p>Jalan Jatibanteng No. 06 Bloro Kode Pos 68356</p>
        </div>

        <div class="line-thin"></div>
        <div class="line-bold"></div>

    </div>

    <!-- ================= JUDUL ================= -->
    <div class="judul">
        <b>SURAT KETERANGAN KEMATIAN</b>
    </div>

    <div class="nomor">
        Nomor Reg. : {{ $details['nomor'] }}/431.502.2.6/{{ $details['tahun'] }}
    </div>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Yang bertanda tangan di bawah ini Kepala Desa Bloro, Kecamatan Besuki Kabupaten Situbondo, menerangkan dengan sebenarnya :
    </div>

    <!-- ================= DATA UTAMA ================= -->
    <table class="data">
        <tr>
            <td class="label">Nama</td>
            <td style="width:5px;">:</td>
            <td><b>{{ $surat->nama }}</b></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $details['nik'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $details['jenis_kelamin'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $details['alamat'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Telah meninggal dunia pada :
    </div>

    <!-- ================= DATA KEMATIAN ================= -->
    <table class="data">
        <tr>
            <td class="label">Hari</td>
            <td style="width:5px;">:</td>
            <td>{{ $details['hari'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $details['tanggal_meninggal'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jam</td>
            <td>:</td>
            <td>{{ $details['jam'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Di</td>
            <td>:</td>
            <td>{{ $details['tempat_meninggal'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><strong>{{ $details['keterangan'] ?? '-' }}</strong></td>
        </tr>
    </table>

    <!-- ================= PENUTUP ================= -->
    <div class="paragraf">
        Demikian surat keterangan ini dibuat atas dasar yang sebenarnya dan dapat dipergunakan sebagaimana mestinya.
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