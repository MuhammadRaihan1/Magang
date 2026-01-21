@extends('layouts.mahasiswa')

@section('title', 'Detail Laporan')

@section('content')
<style>
  .dl-wrap{max-width:980px;}
  .dl-title{font-size:28px;margin:0 0 6px;color:#111827;font-weight:600;}
  .dl-sub{margin:0 0 18px;color:#6b7280;font-size:13px;font-weight:400;}

  .dl-card{
    background:#fff;
    border:1px solid rgba(17,24,39,.10);
    border-radius:16px;
    padding:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
  }

  .dl-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:14px;
  }
  @media (max-width: 900px){
    .dl-grid{grid-template-columns:1fr;}
  }

  .dl-box{
    border:1px solid rgba(17,24,39,.10);
    border-radius:14px;
    padding:12px 14px;
    background:#fff;
  }
  .dl-label{
    font-size:12px;
    color:#6b7280;
    letter-spacing:.2px;
    text-transform:uppercase;
    margin:0 0 6px;
    font-weight:400;
  }
  .dl-value{
    margin:0;
    color:#111827;
    font-size:14px;
    font-weight:400;
  }

  .dl-activity{
    grid-column: 1 / -1;
    border:1px solid rgba(17,24,39,.10);
    border-radius:14px;
    padding:14px;
    background:#f9fafb;
    color:#111827;
    font-weight:400;
    white-space:pre-wrap;
    min-height:90px;
  }

  .dl-status{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 12px;
    border-radius:999px;
    border:1px solid transparent;
    font-size:12px;
    font-weight:400;
    white-space:nowrap;
  }
  .st-pending{background:#fff7ed;color:#9a3412;border-color:#fed7aa;}
  .st-approved{background:#ecfdf5;color:#065f46;border-color:#a7f3d0;}
  .st-rejected{background:#fef2f2;color:#991b1b;border-color:#fecaca;}

  .dl-attach{
    grid-column: 1 / -1;
    border:1px solid rgba(17,24,39,.10);
    border-radius:14px;
    overflow:hidden;
    background:#fff;
  }
  .dl-attach-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding:12px 14px;
    background:#fbfbfc;
    border-bottom:1px solid rgba(17,24,39,.10);
  }
  .dl-attach-body{padding:14px;}
  .dl-img{
    width:100%;
    max-height:420px;
    object-fit:contain;
    border-radius:12px;
    border:1px solid rgba(17,24,39,.10);
    background:#fff;
  }
  .dl-hint{margin-top:8px;color:#6b7280;font-size:12px;font-weight:400;}

  .dl-btnbar{
    display:flex;
    justify-content:flex-end;
    margin-top:16px;
  }
  .dl-back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:#b91c1c;
    color:#fff;
    text-decoration:none;
    padding:10px 14px;
    border-radius:12px;
    font-weight:400;
    border:1px solid rgba(0,0,0,.06);
  }
</style>

@php
  $status = $kegiatan->status ?? 'Pending';
  $stClass = $status === 'Approved' ? 'st-approved' : ($status === 'Rejected' ? 'st-rejected' : 'st-pending');
@endphp

<div class="dl-wrap">
  <h1 class="dl-title">Detail Laporan</h1>
  <p class="dl-sub">Informasi laporan kegiatan harian dan hasil verifikasi supervisor.</p>

  <div class="dl-card">
    <div class="dl-grid">
      <div class="dl-box">
        <p class="dl-label">Tanggal</p>
        <p class="dl-value">{{ optional($kegiatan->tanggal)->format('d-m-Y') }}</p>
      </div>

      <div class="dl-box">
        <p class="dl-label">Status</p>
        <span class="dl-status {{ $stClass }}">● {{ $status }}</span>
      </div>

      <div class="dl-box">
        <p class="dl-label">Jam Masuk</p>
        <p class="dl-value">{{ $kegiatan->jam_masuk ?? '-' }}</p>
      </div>

      <div class="dl-box">
        <p class="dl-label">Jam Pulang</p>
        <p class="dl-value">{{ $kegiatan->jam_pulang ?? '-' }}</p>
      </div>

      <div class="dl-box" style="grid-column:1/-1;">
        <p class="dl-label">Catatan Supervisor</p>
        <p class="dl-value">{{ $kegiatan->catatan_supervisor ?? '-' }}</p>
      </div>

      <div style="grid-column:1/-1;">
        <p class="dl-label" style="margin:0 0 8px;">Aktivitas</p>
        <div class="dl-activity">{{ $kegiatan->aktivitas ?? '-' }}</div>
      </div>

      <div class="dl-attach">
        <div class="dl-attach-head">
          <div class="dl-label" style="margin:0;">Lampiran</div>

          @if(!empty($kegiatan->lampiran))
            <a href="{{ asset('storage/kegiatan/' . $kegiatan->lampiran) }}" target="_blank"
               style="text-decoration:none;border:1px solid rgba(17,24,39,.18);border-radius:10px;padding:8px 12px;color:#111827;font-weight:400;background:#fff;">
              Buka
            </a>
          @endif
        </div>

        <div class="dl-attach-body">
          @if(!empty($kegiatan->lampiran))
            @php
              $ext = strtolower(pathinfo($kegiatan->lampiran, PATHINFO_EXTENSION));
              $url = asset('storage/kegiatan/' . $kegiatan->lampiran);
            @endphp

            @if(in_array($ext, ['jpg','jpeg','png']))
              <img class="dl-img" src="{{ $url }}" alt="Lampiran">
              <div class="dl-hint">Klik “Buka” untuk melihat ukuran penuh.</div>
            @else
              <div class="dl-value">{{ $kegiatan->lampiran }}</div>
              <div class="dl-hint">Klik “Buka” untuk melihat / download file.</div>
            @endif
          @else
            <div class="dl-hint">Tidak ada lampiran.</div>
          @endif
        </div>
      </div>
    </div>

    <div class="dl-btnbar">
      <a class="dl-back" href="{{ route('mahasiswa.kegiatan.index') }}">Kembali</a>
    </div>
  </div>
</div>
@endsection
