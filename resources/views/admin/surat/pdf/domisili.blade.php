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

        .header {
            position: relative;
            text-align: center;
        }

        .logo {
            position: absolute;
            left: 10px;
            top: 2px;
            width: 80px;
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

        .judul {
            text-align: center;
        }

        .judul b {
            text-decoration: underline;
            font-size: 14pt;
        }

        .nomor {
            text-align: center;
            margin-top: 4px;
        }

        .paragraf {
            text-align: justify;
            text-indent: 1.25cm;
            margin-top: 10px;
        }

        .data-table {
            margin-top: 10px;
            margin-left: 3.5cm;
        }

        .data-table td {
            padding: 2px 6px;
            vertical-align: top;
        }

        .label {
            width: 5cm;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd-kanan {
            float: right;
            text-align: center;
            margin-right: 2cm;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

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

<div class="judul">
    <b>SURAT KETERANGAN DOMISILI</b>
</div>

<div class="nomor">
    No.Reg. 140/{{ $details['nomor'] ?? '-' }}/431.502.2.6/{{ $details['tahun'] ?? date('Y') }}
</div>

<div class="paragraf">
    Yang bertanda tangan dibawah ini kami, Kepala Desa Bloro, Kecamatan Besuki Kabupaten Situbondo, menerangkan dengan sebenarnya bahwa :
</div>

<table class="data-table">
<tr>
    <td class="label">Nama</td>
    <td>: <strong>{{ $details['nama'] ?? $surat->nama ?? '-' }}</strong></td>
</tr>
<tr>
    <td>NIK</td>
    <td>: {{ $details['nik'] ?? '-' }}</td>
</tr>
<tr>
    <td>Tempat & Tgl Lahir</td>
    <td>: {{ $details['ttl'] ?? '-' }}</td>
</tr>
<tr>
    <td>Jenis Kelamin</td>
    <td>: {{ $details['jenis_kelamin'] ?? '-' }}</td>
</tr>
<tr>
    <td>Kewarganegaraan</td>
    <td>: {{ $details['kewarganegaraan'] ?? '-' }}</td>
</tr>
<tr>
    <td>Agama</td>
    <td>: {{ $details['agama'] ?? '-' }}</td>
</tr>
<tr>
    <td>Status Perkawinan</td>
    <td>: {{ $details['status_perkawinan'] ?? '-' }}</td>
</tr>
<tr>
    <td>Pekerjaan</td>
    <td>: {{ $details['pekerjaan'] ?? '-' }}</td>
</tr>
<tr>
    <td>Alamat</td>
    <td>: {{ $details['alamat'] ?? '-' }}</td>
</tr>
</table>

<div class="paragraf">
    Demikian surat keterangan ini dibuat agar dipergunakan dengan semestinya.
</div>

<div class="ttd">
    <div class="ttd-kanan">
        Bloro, {{ $details['tanggal_surat'] ?? date('d F Y') }}<br>
        Kepala Desa Bloro<br><br><br><br>

        <span class="nama-kades">EDY SUSIYANTO</span>
    </div>
</div>

<div class="clear"></div>

</body>
</html>