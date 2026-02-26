@extends('supervisor.layout')

@section('title', 'Detail Laporan Kegiatan')

@section('content')

<style>
    *{
        font-family: "Times New Roman", Times, serif;
        font-size:13px;
        font-weight:normal;
    }

    .page-head{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:10px;
    }

    .page-title{
        font-size:16px;
        margin:0;
        font-weight:normal;
    }

    .status-badge{
        padding:4px 10px;
        border-radius:20px;
        font-size:12px;
        border:1px solid #ccc;
    }

    .status-pending{ background:#fff7ed; color:#9a3412; }
    .status-approved{ background:#ecfdf5; color:#065f46; }
    .status-rejected{ background:#fef2f2; color:#991b1b; }

    .cardx{
        background:#fff;
        border:1px solid #ddd;
        border-radius:8px;
        padding:12px;
    }

    .section{
        margin-bottom:8px;
    }

    .section-title{
        margin-bottom:2px;
    }

    .box{
        border:1px solid #ddd;
        border-radius:4px;
        padding:6px 8px;
        background:#fafafa;
    }

    textarea{
        width:100%;
        border:1px solid #ccc;
        border-radius:4px;
        padding:6px;
        font-size:13px;
    }

    .btnx{
        padding:4px 12px;
        border-radius:4px;
        border:none;
        cursor:pointer;
        font-size:13px;
        color:#fff;
    }

    .btn-success{ background:#16a34a; }
    .btn-danger{ background:#ef4444; }
    .btn-secondary{ background:#6b7280; }

    hr{
        margin:10px 0;
    }
</style>

@php
    $status = strtolower($kegiatan->status ?? 'pending');

    $badgeClass = match($status) {
        'approved' => 'status-approved',
        'rejected' => 'status-rejected',
        default => 'status-pending'
    };
@endphp

<div class="page-head">
    <div class="page-title">Detail Laporan Kegiatan</div>
    <div class="status-badge {{ $badgeClass }}">
        Status: {{ ucfirst($status) }}
    </div>
</div>

<div class="cardx">

    <div class="section">
        <div class="section-title">Mahasiswa</div>
        <div class="box">{{ $kegiatan->mahasiswa->name }}</div>
    </div>

    <div class="section">
        <div class="section-title">Tanggal</div>
        <div class="box">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</div>
    </div>

    <div class="section">
        <div class="section-title">Jam Masuk</div>
        <div class="box">{{ $kegiatan->jam_masuk }}</div>
    </div>

    <div class="section">
        <div class="section-title">Jam Pulang</div>
        <div class="box">{{ $kegiatan->jam_pulang }}</div>
    </div>

    <div class="section">
        <div class="section-title">Aktivitas</div>
        <div class="box">{{ $kegiatan->aktivitas }}</div>
    </div>

    <div class="section">
        <div class="section-title">Catatan Supervisor</div>
        <div class="box">{{ $kegiatan->catatan_supervisor ?? '-' }}</div>
    </div>

    <div class="section">
        <div class="section-title">Lampiran</div>
        <div class="box">
            @if($kegiatan->lampiran)
                <a href="{{ asset('storage/kegiatan/'.$kegiatan->lampiran) }}" target="_blank">
                    Lihat Lampiran
                </a>
            @else
                Tidak ada lampiran.
            @endif
        </div>
    </div>

    @if($status === 'pending')
    <hr>

    <div class="section">
        <form method="POST" action="{{ route('supervisor.kegiatan.approve',$kegiatan->id) }}">
            @csrf
            @method('PATCH')

            <div class="section-title">Catatan (opsional)</div>
            <textarea name="catatan_supervisor" rows="2"></textarea>
            <br>
            <button type="submit" class="btnx btn-success">Setujui</button>
        </form>
    </div>

    <div class="section">
        <form method="POST" action="{{ route('supervisor.kegiatan.reject',$kegiatan->id) }}">
            @csrf
            @method('PATCH')

            <div class="section-title">Alasan Penolakan</div>
            <textarea name="catatan_supervisor" rows="2" required></textarea>
            <br>
            <button type="submit" class="btnx btn-danger">Tolak</button>
        </form>
    </div>
    @endif

</div>

<br>

<div style="text-align:right;">
    <a href="{{ route('supervisor.kegiatan.index') }}">
        <button class="btnx btn-secondary">← Kembali</button>
    </a>
</div>

@endsection