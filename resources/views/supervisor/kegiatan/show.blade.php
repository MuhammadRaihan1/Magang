@extends('supervisor.layout')

@section('title', 'Detail Laporan Kegiatan')

@section('content')
<style>
    .page-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:16px;
        margin-bottom:16px;
    }
    .page-title{
        font-size:22px;
        font-weight:400;
        margin:0;
        color:#0f172a;
    }
    .page-subtitle{
        margin:6px 0 0;
        color:#64748b;
        font-weight:400;
        font-size:13px;
    }
    .status-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:8px 12px;
        border-radius:999px;
        font-weight:400;
        font-size:12px;
        border:1px solid transparent;
        white-space:nowrap;
    }
    .status-pending{ background:#fff7ed; color:#9a3412; border-color:#fed7aa; }
    .status-approved{ background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
    .status-rejected{ background:#fef2f2; color:#991b1b; border-color:#fecaca; }

    .cardx{
        background:#fff;
        border:1px solid rgba(15,23,42,.08);
        border-radius:16px;
        box-shadow:0 4px 14px rgba(0,0,0,.06);
    }
    .cardx-body{ padding:18px; }

    .info-grid{
        display:grid;
        grid-template-columns:1.1fr .9fr;
        gap:14px;
    }
    @media(max-width:992px){
        .info-grid{ grid-template-columns:1fr; }
    }

    .infobox{
        border:1px solid rgba(15,23,42,.08);
        border-radius:14px;
        padding:14px;
    }
    .infobox-title{
        font-size:12px;
        font-weight:400;
        color:#64748b;
        margin-bottom:6px;
        text-transform:uppercase;
    }
    .infobox-value,
    .infobox-muted{
        font-size:14px;
        font-weight:400;
        color:#0f172a;
        margin:0;
    }

    .activity-box{
        border-radius:14px;
        border:1px solid rgba(15,23,42,.08);
        background:#f8fafc;
        padding:14px;
        font-weight:400;
    }

    .attach-wrap{
        border:1px solid rgba(15,23,42,.08);
        border-radius:14px;
        overflow:hidden;
    }
    .attach-head{
        display:flex;
        justify-content:space-between;
        padding:12px 14px;
        background:#fbfbfc;
        border-bottom:1px solid rgba(15,23,42,.08);
    }
    .attach-title{
        font-weight:400;
        font-size:14px;
        margin:0;
    }
    .attach-body{ padding:14px; }

    .attach-img{
        width:100%;
        max-height:420px;
        object-fit:contain;
        border-radius:12px;
        border:1px solid rgba(15,23,42,.08);
    }

    .divider{
        height:1px;
        background:rgba(15,23,42,.08);
        margin:16px 0;
    }

    .btnx{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:10px 14px;
        border-radius:10px;
        font-weight:400;
        text-decoration:none;
        border:1px solid transparent;
    }
    .btnx-secondary{ background:#6b7280; color:#fff; }
    .btnx-success{ background:#16a34a; color:#fff; }
    .btnx-danger{ background:#ef4444; color:#fff; }
    .btnx-outline{
        background:#fff;
        border-color:rgba(15,23,42,.2);
        color:#0f172a;
    }

    .form-control{
        border-radius:12px;
        font-weight:400;
    }
</style>

@php
    $status = $kegiatan->status ?? 'Pending';
    $badgeClass = $status === 'Approved' ? 'status-approved' : ($status === 'Rejected' ? 'status-rejected' : 'status-pending');
@endphp

<div class="page-head">
    <div>
        <h1 class="page-title">Detail Laporan Kegiatan</h1>
        <p class="page-subtitle">
            Periksa laporan, lampiran, lalu setujui atau tolak jika diperlukan.
        </p>
    </div>

    <div class="status-badge {{ $badgeClass }}">
        Status: {{ $status }}
    </div>
</div>

<div class="cardx">
    <div class="cardx-body">

        <div class="info-grid">
            <div>
                <div class="infobox mb-3">
                    <div class="infobox-title">Mahasiswa</div>
                    <div class="infobox-value">{{ $kegiatan->mahasiswa->name }}</div>
                </div>

                <div class="infobox mb-3">
                    <div class="infobox-title">Aktivitas</div>
                    <div class="activity-box">{{ $kegiatan->aktivitas }}</div>
                </div>

                <div class="infobox">
                    <div class="infobox-title">Catatan Supervisor</div>
                    <div class="infobox-muted">{{ $kegiatan->catatan_supervisor ?? '-' }}</div>
                </div>
            </div>

            <div>
                <div class="infobox mb-3">
                    <div class="infobox-title">Tanggal</div>
                    <div class="infobox-value">{{ $kegiatan->tanggal->format('d-m-Y') }}</div>
                </div>

                <div class="infobox mb-3">
                    <div class="infobox-title">Jam Masuk</div>
                    <div class="infobox-value">{{ $kegiatan->jam_masuk }}</div>
                </div>

                <div class="infobox mb-3">
                    <div class="infobox-title">Jam Pulang</div>
                    <div class="infobox-value">{{ $kegiatan->jam_pulang }}</div>
                </div>

                <div class="attach-wrap">
                    <div class="attach-head">
                        <div class="attach-title">Lampiran</div>
                        @if($kegiatan->lampiran)
                            <a href="{{ asset('storage/kegiatan/'.$kegiatan->lampiran) }}"
                               target="_blank"
                               class="btnx btnx-outline">
                                Buka
                            </a>
                        @endif
                    </div>

                    <div class="attach-body">
                        @if($kegiatan->lampiran)
                            <img src="{{ asset('storage/kegiatan/'.$kegiatan->lampiran) }}"
                                 class="attach-img">
                        @else
                            <div class="infobox-muted">Tidak ada lampiran.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        @if($kegiatan->status === 'Pending')
        <div class="row g-3">
            <div class="col-md-6">
                <form method="POST" action="{{ route('supervisor.kegiatan.approve',$kegiatan->id) }}">
                    @csrf @method('PATCH')
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea name="catatan_supervisor" class="form-control" rows="3"></textarea>
                    <button class="btnx btnx-success mt-3">Setujui</button>
                </form>
            </div>

            <div class="col-md-6">
                <form method="POST" action="{{ route('supervisor.kegiatan.reject',$kegiatan->id) }}">
                    @csrf @method('PATCH')
                    <label class="form-label">Alasan penolakan</label>
                    <textarea name="catatan_supervisor" class="form-control" rows="3" required></textarea>
                    <button class="btnx btnx-danger mt-3">Tolak</button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- TOMBOL KEMBALI DI PALING BAWAH --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('supervisor.kegiatan.index') }}" class="btnx btnx-secondary">
        ← Kembali
    </a>
</div>

@endsection
