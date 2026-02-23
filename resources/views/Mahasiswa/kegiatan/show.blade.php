@extends('layouts.mahasiswa')

@section('title','Detail Laporan')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#e6edf5;
    font-family:"Times New Roman", Times, serif;
}

.page-title{
    font-size:19px;
    margin:0 10px 2px 10px;
    font-weight:normal;
}

.page-sub{
    margin:0 10px 10px 10px;
    font-size:12px;
    color:#6b7280;
}

.detail-card{
    background:#f8fafc;
    margin:0 10px 15px 10px;
    padding:14px 16px;
    border-radius:6px;
    border:1px solid #cbd5e1;
    width:calc(100% - 20px);
}

.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
}

@media(max-width:900px){
    .detail-grid{
        grid-template-columns:1fr;
    }
}

.detail-box{
    background:#ffffff;
    border:1px solid #cbd5e1;
    border-radius:4px;
    padding:7px 9px;
}

.detail-label{
    font-size:11px;
    color:#6b7280;
    margin-bottom:2px;
}

.detail-value{
    font-size:13px;
    color:#111827;
}

.detail-activity{
    grid-column:1/-1;
    background:#ffffff;
    border:1px solid #cbd5e1;
    border-radius:4px;
    padding:9px;
    min-height:60px;
    font-size:13px;
    white-space:pre-wrap;
}

.detail-status{
    display:inline-block;
    padding:3px 8px;
    border-radius:10px;
    font-size:11px;
    background:#e5e7eb;
}

.st-approved{background:#dcfce7;}
.st-rejected{background:#fee2e2;}
.st-pending{background:#fef3c7;}

.detail-attach{
    grid-column:1/-1;
    background:#ffffff;
    border:1px solid #cbd5e1;
    border-radius:4px;
    padding:9px;
}

.detail-img{
    width:100%;
    max-height:250px;
    object-fit:contain;
    border:1px solid #cbd5e1;
    border-radius:4px;
}

.btn-back{
    background:#dc2626;
    color:#fff;
    padding:5px 12px;
    border-radius:5px;
    text-decoration:none;
    font-size:12px;
}

.btn-bar{
    margin-top:10px;
    text-align:right;
}
</style>

@php
$status = $kegiatan->status ?? 'Pending';
$stClass = $status === 'Approved' ? 'st-approved' :
          ($status === 'Rejected' ? 'st-rejected' : 'st-pending');
@endphp

<div class="page-title">
    Detail Laporan
</div>

<div class="page-sub">
    Informasi laporan kegiatan harian dan hasil verifikasi supervisor.
</div>

<div class="detail-card">

    <div class="detail-grid">

        <div class="detail-box">
            <div class="detail-label">Tanggal</div>
            <div class="detail-value">
                {{ optional($kegiatan->tanggal)->format('d-m-Y') }}
            </div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Status</div>
            <span class="detail-status {{ $stClass }}">
                {{ $status }}
            </span>
        </div>

        <div class="detail-box">
            <div class="detail-label">Jam Masuk</div>
            <div class="detail-value">
                {{ $kegiatan->jam_masuk ?? '-' }}
            </div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Jam Pulang</div>
            <div class="detail-value">
                {{ $kegiatan->jam_pulang ?? '-' }}
            </div>
        </div>

        <div class="detail-box" style="grid-column:1/-1;">
            <div class="detail-label">Catatan Supervisor</div>
            <div class="detail-value">
                {{ $kegiatan->catatan_supervisor ?? '-' }}
            </div>
        </div>

        <div style="grid-column:1/-1;">
            <div class="detail-label" style="margin-bottom:6px;">Aktivitas</div>
            <div class="detail-activity">
                {{ $kegiatan->aktivitas ?? '-' }}
            </div>
        </div>

        <div class="detail-attach">
            <div class="detail-label" style="margin-bottom:8px;">Lampiran</div>

            @if(!empty($kegiatan->lampiran))
                @php
                    $ext = strtolower(pathinfo($kegiatan->lampiran, PATHINFO_EXTENSION));
                    $url = asset('storage/kegiatan/'.$kegiatan->lampiran);
                @endphp

                @if(in_array($ext,['jpg','jpeg','png']))
                    <img src="{{ $url }}" class="detail-img">
                @else
                    <a href="{{ $url }}" target="_blank">{{ $kegiatan->lampiran }}</a>
                @endif
            @else
                <div style="font-size:12px;color:#6b7280;">
                    Tidak ada lampiran.
                </div>
            @endif
        </div>

    </div>

    <div class="btn-bar">
        <a href="{{ route('mahasiswa.kegiatan.index') }}" class="btn-back">
            Kembali
        </a>
    </div>

</div>

@endsection