<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lembar Hasil Penilaian</title>

<style>
@page { size: A4 portrait; margin: 14mm 16mm 10mm 16mm; }

body{
  font-family:"DejaVu Sans", sans-serif;
  font-size:11px;
  color:#000;
  margin:0;
}

.paper{
  border:1px solid #111;
  padding:14px 14px 10px;
}

.kop{
  position:relative;
  text-align:center;
  padding-bottom:12px;
  min-height:110px;
}

.kop .logo{
  position:absolute;
  left:0;
  top:18px;
  width:100px;
}

.kop img{
  width:95px;
  height:auto;
  display:block;
}

.kop .nilai{
  font-weight:700;
  font-size:17px;
  text-transform:uppercase;
  letter-spacing:.4px;
  line-height:1.2;
  margin-top:12px;
}

.kop .bank{
  font-weight:700;
  font-size:11.5px;
  text-transform:uppercase;
  margin-top:4px;
}

.line{
  border-top:1px solid #777;
  margin:10px 0 8px;
  width: calc(100% + 28px);
  margin-left: -14px;
}

.content{
  font-family:"Times New Roman", Times, serif;
  text-align:left;
}

.ident{
  margin-top:6px;
  margin-bottom:8px;
  font-size:11px;
  font-weight:700;
}

.ident table{
  width:100%;
  border-collapse:collapse;
}

.ident td{
  padding:2px 0;
  vertical-align:top;
  line-height:1.3;
}

.ident .label{
  width:160px;
  position:relative;
  padding-right:14px;
}

.ident .label span{
  position:absolute;
  right:0;
  top:0;
  width:14px;
  text-align:center;
}

.ident .value{
  padding-left:6px;
}

.main{
  width:100%;
  border-collapse:collapse;
  table-layout:fixed;
  font-size:10.3px;
}

.main th,.main td{
  border:1px solid #111;
  padding:5px 6px;
  line-height:1.25;
  vertical-align:top;
}

.main th{
  text-align:center;
  font-weight:700;
  background:#f5f5f5;
}

.c-no{width:34px;text-align:center;font-weight:700;}
.c-range{width:180px;text-align:center;font-size:10px;}
.c-nilai{width:52px;text-align:center;font-weight:700;}

.sum{
  width:100%;
  border-collapse:collapse;
  margin-top:6px;
  font-size:11px;
}

.sum td{
  border:1px solid #111;
  padding:5px 7px;
  font-weight:700;
}

.sum .label{width:70%;}
.sum .val{width:30%;text-align:right;}

.ttd{
  margin-top:10px;
  font-size:11px;
  font-weight:700;
}

.ttd-right{
  width:45%;
  margin-left:auto;
  line-height:1.5;
}

.ttd-right .place{
  margin-bottom:4px;
}

.ttd-right .jabatan{
  margin-bottom:56px;
}

.ttd-right .nama{
  text-decoration:underline;
}

.ttd-right .nip{
  margin-top:3px;
}

.foot{
  margin-top:6px;
  font-size:9.5px;
  font-family:"Times New Roman", Times, serif;
}

table,tr,td,th{page-break-inside:avoid;}
</style>
</head>

<body>

@php
  $logoPath = public_path('images/bank.png');
  $logoData = null;

  if (file_exists($logoPath)) {
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPath);
    $logoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
  }

  $aspek = [
    'Penguasaan ilmu bidang studi (teori) penunjang praktek',
    'Keterampilan membaca gambar kerja / petunjuk',
    'Keterampilan menggunakan alat / instrumen praktek',
    'Kapasitas hasil praktek sesuai waktu yang disediakan',
    'Kualitas hasil praktek dibanding standar (tolak ukur)',
    'Kemampuan berpraktek secara mandiri',
    'Inisiatif meningkatkan hasil praktek',
    'Inisiatif menyelesaikan / mengatasi masalah',
    'Kerja sama dengan orang lain selama praktek',
    'Disiplin dan kehadiran di tempat praktek',
    'Tanggung jawab dalam bekerja',
    'Etika / sopan santun selama praktek',
    'Komunikasi dengan pembimbing / tim',
    'Kerapian dan ketelitian kerja',
    'Keselamatan dan kesehatan kerja (K3)',
  ];

  $nilai = $penilaian->nilai ?? [];
  $rangeText = '1=20 | 2=40 | 3=60 | 4=80 | 5=100';

  $namaPejabat =
    optional(optional($penilaian)->supervisor)->name
    ?? 'Supervisor';

  $nipPejabat =
    optional(optional($penilaian)->supervisor)->nip
    ?? '-';
@endphp

<div class="paper">

  <div class="kop">
    <div class="logo">
      @if($logoData)
        <img src="{{ $logoData }}" alt="Logo">
      @endif
    </div>

    <div class="nilai">NILAI AKHIR MAHASISWA MAGANG</div>
    <div class="bank">BANK NAGARI PADANG</div>
    <div class="line"></div>
  </div>

  <div class="content">

    <div class="ident">
      <table>
        <tr>
          <td class="label">Nama Mahasiswa<span>:</span></td>
          <td class="value">{{ $mahasiswa->name ?? '-' }}</td>
        </tr>
        <tr>
          <td class="label">Email<span>:</span></td>
          <td class="value">{{ $mahasiswa->email ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <table class="main">
      <thead>
        <tr>
          <th class="c-no">No</th>
          <th>Aspek yang Dinilai</th>
          <th class="c-range">Range Penilaian</th>
          <th class="c-nilai">Nilai</th>
        </tr>
      </thead>
      <tbody>
        @for($i=0; $i<15; $i++)
          <tr>
            <td class="c-no">{{ $i+1 }}</td>
            <td>{{ $aspek[$i] ?? ('Aspek ' . ($i+1)) }}</td>
            <td class="c-range">{{ $rangeText }}</td>
            <td class="c-nilai">{{ $nilai[$i] ?? '-' }}</td>
          </tr>
        @endfor
      </tbody>
    </table>

    <table class="sum">
      <tr>
        <td class="label">Total</td>
        <td class="val">{{ $penilaian->total_skor ?? 0 }}</td>
      </tr>
      <tr>
        <td class="label">Nilai Akhir</td>
        <td class="val">{{ number_format($penilaian->nilai_akhir ?? 0, 2) }}</td>
      </tr>
      <tr>
        <td class="label">Grade</td>
        <td class="val">{{ $penilaian->grade ?? '-' }}</td>
      </tr>
    </table>

    <div class="ttd">
      <div class="ttd-right">
        <div class="place">Padang, {{ now()->format('d-m-Y') }}</div>
        <div class="jabatan">Pembimbing Lapangan</div>
        <div class="nama">{{ $namaPejabat }}</div>
        <div class="nip">NIP. {{ $nipPejabat }}</div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
