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
            /* 🔥 BODY WORD */
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
        }

        /* ================= PARAGRAF ================= */
        .paragraf {
            text-align: justify;
            text-indent: 1.25cm;
            margin-top: 10px;
        }
        .teks {
            text-align: justify;
            text-indent: 0cm;
            margin-top: 10px;
            font-size: 12pt;
        }

        /* ================= DATA ================= */
        .data {
            margin: 15px 0;
            margin-left: 1.5cm;
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
            width: 200px;
            margin-left: auto;
            margin-right: 1cm;
            text-align: center;
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
            <p>Jalan Jatibanteng Nomor 06 Bloro Kode Pos 68356</p>
        </div>

        <div class="line-thin"></div>
        <div class="line-bold"></div>

    </div>

    <!-- ================= JUDUL ================= -->
    <div class="judul">
        <b>SURAT KETERANGAN USAHA</b>
    </div>

    <div class="nomor">
        Nomor : 145/{{ $details['nomor'] }}/431.502.2.6/{{ $details['tahun'] }}
    </div>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Yang bertanda tangan dibawah ini kami, Kepala Desa Bloro, Kecamatan Besuki, Kabupaten Situbondo menerangkan bahwa :
    </div>

    <!-- ================= DATA ================= -->
    <table class="data">
        <tr>
            <td class="label">Nama</td>
            <td style="width:5px;">:</td>
            <td><b>{{ $details['nama'] ?? '-' }}</b></td>
        </tr>
        <tr>
            <td>Tempat & Tgl Lahir</td>
            <td>:</td>
            <td>{{ $details['ttl'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $details['nik'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $details['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $details['status'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Usaha</td>
            <td>:</td>
            <td><strong>{{ $details['usaha'] ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $details['alamat'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td><b>{{ $details['keperluan'] ?? '-' }}</b></td>
        </tr>
    </table>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Orang tersebut diatas benar-benar warga Desa Bloro, Kecamatan Besuki, Kabupaten Situbondo, dan mempunyai lapangan usaha sebagaimana disebut di atas.
    </div>

    <div class="teks">
        Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    <!-- ================= TTD ================= -->
    <div class="ttd">
        Bloro, {{ $details['tanggal_surat'] }}<br>
        Kepala Desa Bloro<br><br><br><br>
        <span class="nama">EDY SUSIYANTO</span>
    </div>

</body>

</html>