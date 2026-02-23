@extends('layouts.mahasiswa')

@section('title','Laporan Kegiatan')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#e6edf5;
    font-family:"Times New Roman", Times, serif;
    font-weight:normal;
}

.container,
.container-fluid,
.content-wrapper,
.main-content,
.page-content{
    max-width:100% !important;
    width:100% !important;
    margin:0 !important;
    padding:0 !important;
}

.page-title{
    font-size:24px;
    margin:0 6px 4px 6px;
    font-weight:normal;
}

.report-box{
    margin:0 3px 15px 3px;
    background:#f8fafc;
    border-radius:12px;
    border:1px solid #cbd5e1;
    overflow:hidden;
    width:calc(100% - 6px);
}

.report-header{
    background:#BCC9EE;
    color:#000000;
    padding:12px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:16px;
    font-weight:normal;
}

.header-btn{
    background:#ffffff;
    color:#000;
    padding:5px 14px;
    border-radius:16px;
    text-decoration:none;
    border:1px solid #cbd5e1;
    font-size:13px;
    margin-left:6px;
}

.report-table{
    width:100%;
    border-collapse:collapse;
    background:#ffffff;
}

.report-table th,
.report-table td{
    border:1px solid #cfd8e3;
    padding:8px 10px;
    font-size:14px;
    font-weight:normal;
    text-align:left;
    vertical-align:middle;
}

.report-table th{
    background:#eef2f7;
}

.status-badge{
    background:#6b7280;
    color:#fff;
    padding:3px 10px;
    border-radius:12px;
    font-size:12px;
}

.detail-link{
    color:#2563eb;
    text-decoration:none;
    font-size:14px;
}

.report-footer{
    padding:8px 15px;
    font-size:13px;
    display:flex;
    justify-content:space-between;
    color:#555;
}
</style>

<div class="page-title">
    Laporan Kegiatan
</div>

<div class="report-box">

    <div class="report-header">
        <div>
            Riwayat Laporan Kegiatan Harian
        </div>

        <div>
            <a href="{{ route('mahasiswa.kegiatan.print') }}" class="header-btn">
                Cetak PDF
            </a>
            <a href="{{ route('mahasiswa.kegiatan.create') }}" class="header-btn">
                Tambah
            </a>
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:10%">Tanggal</th>
                <th style="width:15%">Masuk - Pulang</th>
                <th style="width:50%">Aktivitas</th>
                <th style="width:10%">Verifikasi</th>
                <th style="width:10%">Detail</th>
            </tr>
        </thead>

        <tbody>
        @forelse($kegiatans as $i => $k)
            @php
                $no = method_exists($kegiatans,'firstItem') && $kegiatans->firstItem()
                    ? $kegiatans->firstItem() + $i
                    : $i + 1;
            @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ optional($k->tanggal)->format('d/m/Y') }}</td>
                <td>
                    {{ substr($k->jam_masuk,0,5) }}
                    s/d
                    {{ substr($k->jam_pulang,0,5) }}
                </td>
                <td>
                    {{ $k->aktivitas }}
                </td>
                <td>
                    <span class="status-badge">
                        {{ ucfirst($k->status ?? 'Pending') }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('mahasiswa.kegiatan.show',$k->id) }}" class="detail-link">
                        Lihat
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    Belum ada laporan kegiatan.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="report-footer">
        <div>
            Total Data:
            {{ method_exists($kegiatans,'total')
                ? $kegiatans->total()
                : $kegiatans->count() }}
        </div>
        <div>
            {{ now()->format('d-m-Y H:i') }}
        </div>
    </div>

</div>

@endsection