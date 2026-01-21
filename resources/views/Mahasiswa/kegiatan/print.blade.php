<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cetak Laporan Kegiatan</title>
  <style>
    body{ font-family: Arial, sans-serif; padding: 24px; }
    table{ width:100%; border-collapse: collapse; }
    th,td{ border:1px solid #000; padding:8px; font-size:12px; }
    th{ background:#eee; }
  </style>
</head>
<body onload="window.print()">
  <h2>Laporan Kegiatan - {{ auth()->user()->name ?? '' }}</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Masuk-Pulang</th>
        <th>Aktifitas</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($kegiatans as $i => $k)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $k->tanggal->format('d-m-Y') }}</td>
        <td>{{ $k->jam_masuk ?? '-' }} - {{ $k->jam_pulang ?? '-' }}</td>
        <td>{{ $k->aktivitas }}</td>
        <td>{{ $k->status }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
