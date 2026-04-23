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
            margin-left: 1.5cm;
            width: 90%;
        }

        .data td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .label {
            width: 4cm;
        }

        /* ================= LIST ================= */
        .list {
            margin-left: 2cm;
            margin-top: 5px;
        }

        /* ================= KEPERLUAN ================= */
        .keperluan {
            text-align: center;
            margin-top: 10px;
        }

        .keperluan b {
            text-decoration: underline;
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
            <p>Jl. Jatibanteng No. 06 Bloro Kode Pos 68356</p>
        </div>

        <div class="line-thin"></div>
        <div class="line-bold"></div>

    </div>

    <!-- ================= JUDUL ================= -->
    <div class="judul">
        <b>SURAT KETERANGAN KELAKUAN BAIK</b>
    </div>

    <div class="nomor">
        Nomor : 775/{{ $details['nomor'] }}/431.502.2.6/{{ $details['tahun'] }}
    </div>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Yang bertanda tangan dibawah ini kami Kepala Desa Bloro, Kecamatan Besuki, Kabupaten Situbondo, menerangkan dengan sebenarnya bahwa:
    </div>

    <!-- ================= DATA ================= -->
    <table class="data">
        <tr>
            <td class="label">Nama</td>
            <td>:</td>
            <td><b>{{ $details['nama'] ?? '-' }}</b></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $details['nik'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempat Tgl. Lahir</td>
            <td>:</td>
            <td>{{ $details['ttl'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kebangsaan</td>
            <td>:</td>
            <td>{{ $details['kebangsaan'] ?? 'Indonesia' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $details['jenis_kelamin'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $details['status'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $details['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $details['agama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td>:</td>
            <td>{{ $details['pendidikan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $details['alamat'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- ================= PARAGRAF ================= -->
    <div class="paragraf">
        Selama dalam penelitian dan pengawasan kami, yang bersangkutan tersebut diatas betul-betul:
    </div>

    <!-- ================= LIST ================= -->
    <ul class="list">
        <li>Berkelakuan Baik</li>
        <li>Tidak pernah tersangkut / terlibat perkara pidana</li>
    </ul>

    <div class="paragraf">
        Surat Keterangan Kelakuan Baik ini dipergunakan untuk:
    </div>

    <!-- ================= KEPERLUAN ================= -->
    <div class="keperluan">
        = <b>{{ $details['keperluan'] ?? 'Melamar Pekerjaan' }}</b> =
    </div>

    <div class="paragraf">
        Demikian surat keterangan ini dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.
    </div>

    <!-- ================= TTD ================= -->
    <div class="ttd">
        Bloro, {{ $details['tanggal_surat'] }}<br>
        Mengetahui<br>
        Kepala Desa Bloro<br><br><br><br>
        <span class="nama">EDY SUSIYANTO</span>
    </div>

</body>

</html>