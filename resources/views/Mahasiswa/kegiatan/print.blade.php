<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Kegiatan Harian Magang</title>

  <style>
    :root{
      --theme: #63B3ED;   /* biru muda */
      --border: #2f2f2f;
      --text: #000;
    }

    *{ box-sizing: border-box; }

    /* ===== FONT & PRINT COLOR ===== */
    html, body{
      margin: 0;
      padding: 0;
      font-family: "Times New Roman", Times, serif;
      font-size: 12px;
      color: var(--text);
      background: #fff;

      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    /* ===== PAGE A4 ===== */
    .page{
      width: 210mm;
      min-height: 297mm;
      margin: 0 auto;
      padding: 18mm 18mm;
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    /* ===== HEADER ===== */
    .header{
      display: grid;
      grid-template-columns: 120px 1fr;
      align-items: start;
      column-gap: 16px;
    }

    .logo{
      width: 110px;       /* LOGO DIBESARKAN */
      height: auto;
      object-fit: contain;
    }

    .header-text{
      text-align: center;
      margin-top: 6px;
    }

    .title{
      margin: 0;
      font-size: 18px;
      font-weight: bold;
      letter-spacing: .5px;
      text-transform: uppercase;
    }

    .subtitle{
      margin-top: 4px;
      font-size: 13px;
    }

    /* ===== META ===== */
    .meta{
      margin-top: 6px;
      display: grid;
      gap: 6px;
      font-size: 13px;
    }

    .meta-row{
      display: flex;
      gap: 8px;
    }

    .meta-label{
      width: 130px;
      font-weight: bold;
    }

    /* ===== TABLE ===== */
    table{
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-top: 6px;
    }

    th, td{
      border: 1px solid var(--border);
      padding: 10px;
      vertical-align: top;
      word-break: break-word;
    }

    thead th{
      background: var(--theme) !important;
      color: #fff !important;
      font-weight: bold;
      text-align: center;

      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    td.center{ text-align: center; }

    .col-no{ width: 45px; }
    .col-date{ width: 110px; }
    .col-time{ width: 150px; }
    .col-status{ width: 95px; }

    .kegiatan{
      white-space: pre-wrap;
      line-height: 1.5;
    }

    /* ===== FOOTER ===== */
    .spacer{ flex: 1; }

    .footer{
      display: grid;
      grid-template-columns: 1fr 260px;
      margin-top: 14mm;
      font-size: 13px;
    }

    .footer-right{
      line-height: 2;
    }

    .ttd-space{ height: 60px; }

    .line{
      border-bottom: 1px solid #000;
      width: 200px;
      margin: 8px 0 4px;
    }

    /* ===== BUTTON (NO PRINT) ===== */
    .no-print{
      display: flex;
      gap: 10px;
      margin-bottom: 6px;
    }

    .btn{
      font-family: "Times New Roman", Times, serif;
      border: 1px solid #000;
      background: #fff;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 12px;
    }

    @media print{
      .no-print{ display:none !important; }

      @page{
        size: A4;
        margin: 15mm;
      }

      thead{ display: table-header-group; }
      tr{ page-break-inside: avoid; }
    }
  </style>
</head>

<body>
@php
  use Carbon\Carbon;

  $tz = config('app.timezone') ?: 'Asia/Jakarta';

  $nama = optional(auth()->user())->name ?? 'Nama Pemagang';
  $tglCetak = Carbon::now($tz)->format('d/m/Y H:i');

  $rows = $kegiatans ?? collect();

  $instansi = $instansi ?? 'Kantor / Instansi Magang';
  $kota = $kota ?? 'Padang';
  $penanggungJawab = $penanggungJawab ?? 'Pembimbing Magang';
  $nip = $nip ?? '';
@endphp

<div class="page">

  <!-- tombol -->
  <div class="no-print">
    <button class="btn" onclick="window.print()">Cetak / Simpan PDF</button>
    <button class="btn" onclick="history.back()">Kembali</button>
  </div>

  <!-- header -->
  <div class="header">
    <div>
      <img class="logo" src="{{ asset('images/bank.png') }}" alt="Logo Bank">
    </div>

    <div class="header-text">
      <div class="title">LAPORAN KEGIATAN HARIAN MAGANG</div>
      <div class="subtitle">{{ $instansi }}</div>
    </div>
  </div>

  <!-- meta -->
  <div class="meta">
    <div class="meta-row">
      <div class="meta-label">Nama Pemagang</div>
      <div>: {{ $nama }}</div>
    </div>
    <div class="meta-row">
      <div class="meta-label">Tanggal Cetak</div>
      <div>: {{ $tglCetak }}</div>
    </div>
  </div>

  <!-- table -->
  <table>
    <thead>
      <tr>
        <th class="col-no">No</th>
        <th class="col-date">Tanggal</th>
        <th>Kegiatan</th>
        <th class="col-time">Waktu</th>
        <th class="col-status">Status</th>
      </tr>
    </thead>

    <tbody>
      @forelse($rows as $i => $k)
        @php
          $tanggal = !empty($k->tanggal)
            ? Carbon::parse($k->tanggal, $tz)->format('d/m/Y')
            : '-';

          $jamMasuk  = $k->jam_masuk  ? substr((string)$k->jam_masuk, 0, 5) : '-';
          $jamPulang = $k->jam_pulang ? substr((string)$k->jam_pulang, 0, 5) : '-';

          $waktu = $jamMasuk . ' s/d ' . $jamPulang;
          $kegiatanText = $k->aktivitas ?? $k->kegiatan ?? '-';
          $status = $k->status ?? '-';
        @endphp

        <tr>
          <td class="center">{{ $i + 1 }}</td>
          <td class="center">{{ $tanggal }}</td>
          <td class="kegiatan">{{ $kegiatanText }}</td>
          <td class="center">{{ $waktu }}</td>
          <td class="center">{{ $status }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="center">Tidak ada data kegiatan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="spacer"></div>

  <!-- footer -->
  <div class="footer">
    <div></div>
    <div class="footer-right">
      <div>{{ $kota }}, {{ Carbon::now($tz)->format('d/m/Y') }}</div>
      <div>Mengetahui,</div>
      <div>{{ $penanggungJawab }}</div>

      <div class="ttd-space"></div>

      <div class="line"></div>
      <div>NIP: {{ $nip }}</div>
    </div>
  </div>

</div>

<script>
  // auto print (boleh hapus kalau tidak mau)
  window.addEventListener('load', function () {
    setTimeout(function () {
      window.print();
    }, 300);
  });
</script>

</body>
</html>
