<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Kegiatan PLI</title>

<style>
body{
    font-family:"Times New Roman", Times, serif;
    font-size:11px;
    margin:40px;
}

h2{
    text-align:center;
    margin-bottom:5px;
}

.print-date{
    font-size:10px;
    margin-bottom:10px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th, td{
    border:1px solid #000;
    padding:4px;
    font-size:11px;
}

th{
    background:#f2f2f2;
    text-align:center;
}

.center{
    text-align:center;
}

.footer{
    margin-top:30px;
    font-size:11px;
}

@media print{
    button{
        display:none;
    }
}
</style>
</head>

<body>

<div class="print-date">
    {{ date('d/m/Y H:i') }}
</div>

<h2>Laporan Kegiatan PLI</h2>

<table>
<thead>
<tr>
    <th width="30">No</th>
    <th width="90">Tanggal</th>
    <th width="110">Masuk - Pulang</th>
    <th>Aktifitas</th>
    <th width="80">Status</th>
</tr>
</thead>
<tbody>

@foreach($kegiatans as $i => $k)
<tr>
    <td class="center">{{ $i+1 }}</td>
    <td class="center">{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
    <td class="center">
        {{ substr($k->jam_masuk,0,5) }} - {{ substr($k->jam_pulang,0,5) }}
    </td>
    <td>{{ $k->aktivitas }}</td>
    <td class="center">{{ $k->status }}</td>
</tr>
@endforeach

</tbody>
</table>

<div class="footer">
    Dicetak oleh: {{ auth()->user()->name }}
</div>

</body>
</html>