@extends('layouts.mahasiswa')

@section('title', 'Penilaian')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .pen-page{
    padding:24px;
    width:100%;
  }

  .pen-card{
    width:100%;
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 22px 45px rgba(15,23,42,.08);
    overflow:hidden;
  }

  .pen-topbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:18px;
    padding:22px 26px;
    border-bottom:1px solid #e5e7eb;
    background:#fff;
  }

  .pen-title{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:#0f172a;
    letter-spacing:-.02em;
  }

  .pen-subtitle{
    margin-top:6px;
    font-size:14px;
    color:#64748b;
  }

  .pen-body{
    padding:18px 26px 26px;
  }

  .pen-statusbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:12px 14px;
    margin-bottom:14px;
  }

  .pen-status-left{
    display:flex;
    gap:6px;
    align-items:center;
    color:#475569;
    font-size:13px;
  }

  .pen-status-right{
    display:flex;
    align-items:center;
    gap:10px;
    color:#475569;
    font-size:13px;
  }

  .pen-strong{
    font-weight:800;
    color:#0f172a;
  }

  .btn-print-img{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    line-height:1;
  }

  .btn-print-img img{
    width:34px;
    height:34px;
    object-fit:contain;
    opacity:.9;
    transition:.15s ease;
  }

  .btn-print-img:hover img{
    transform:scale(1.08);
    opacity:1;
  }

  .sum-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:12px;
    margin-bottom:14px;
  }

  .sum-card{
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:14px 14px;
    background:#fff;
  }

  .sum-label{
    font-size:12px;
    color:#64748b;
    font-weight:700;
    margin-bottom:6px;
  }

  .sum-value{
    font-size:16px;
    font-weight:900;
    color:#0f172a;
  }

  .grade-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:40px;
    height:26px;
    padding:0 12px;
    border-radius:999px;
    font-weight:900;
    font-size:12px;
    border:1px solid #a7f3d0;
    color:#065f46;
    background:#ecfdf5;
  }

  .table-wrap{
    overflow-x:auto;
    border:1px solid #e5e7eb;
    border-radius:14px;
  }

  table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    min-width:900px;
  }

  thead tr{
    background: linear-gradient(180deg, #eef2ff 0%, #e0e7ff 100%);
  }

  thead th{
    padding:14px 14px;
    font-size:12.5px;
    font-weight:900;
    color:#1e293b;
    text-transform:uppercase;
    letter-spacing:.08em;
    border-bottom:1px solid #e5e7eb;
  }

  tbody td{
    padding:14px 14px;
    border-top:1px solid #eef2f7;
    font-size:13px;
    color:#0f172a;
    vertical-align:middle;
  }

  tbody tr:hover{
    background:#f8fafc;
  }

  .td-center{
    text-align:center;
  }

  .range{
    color:#64748b;
    font-variant-numeric: tabular-nums;
    font-size:12px;
  }

  .nilai-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:54px;
    height:28px;
    padding:0 12px;
    border-radius:999px;
    font-weight:900;
    font-size:12px;
    background:#f1f5f9;
    border:1px solid #e2e8f0;
    color:#0f172a;
  }

  .empty{
    border:1px dashed #cbd5e1;
    border-radius:14px;
    padding:18px;
    color:#64748b;
    background:#fff;
  }

  @media(max-width:992px){
    .sum-grid{
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="pen-page">
  <div class="pen-card">
    <div class="pen-topbar">
      <div>
        <h1 class="pen-title">Penilaian</h1>
        <p class="pen-subtitle">Lihat hasil penilaian dari supervisor.</p>
      </div>
    </div>

    <div class="pen-body">
      <div class="pen-statusbar">
        <div class="pen-status-left">
          <span>Nama:</span>
          <span class="pen-strong">{{ auth()->user()->name }}</span>
        </div>

        <div class="pen-status-right">
          <span>Status:</span>
          <span class="pen-strong">{{ $penilaian ? 'Sudah dinilai' : 'Belum dinilai' }}</span>

          @if($penilaian)
            <a class="btn-print-img"
               href="{{ route('mahasiswa.penilaian.cetak.pdf') }}"
               target="_blank"
               title="Cetak PDF">
              <img src="{{ asset('images/logoprint.png') }}" alt="Cetak PDF">
            </a>
          @endif
        </div>
      </div>

      @if(!$penilaian)
        <div class="empty">
          Penilaian belum tersedia. Silakan tunggu supervisor melakukan penilaian.
        </div>
      @else
        <div class="sum-grid">
          <div class="sum-card">
            <div class="sum-label">Total Skor</div>
            <div class="sum-value">{{ $penilaian->total_skor ?? 0 }}</div>
          </div>

          <div class="sum-card">
            <div class="sum-label">Nilai Akhir</div>
            <div class="sum-value">{{ number_format($penilaian->nilai_akhir ?? 0, 2) }}</div>
          </div>

          <div class="sum-card">
            <div class="sum-label">Grade</div>
            <div class="sum-value">
              <span class="grade-pill">{{ $penilaian->grade ?? '-' }}</span>
            </div>
          </div>
        </div>

        @php
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
        @endphp

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th style="width:60px;">No</th>
                <th>Aspek yang Dinilai</th>
                <th style="width:220px;">Range Penilaian</th>
                <th style="width:120px;" class="td-center">Nilai</th>
              </tr>
            </thead>
            <tbody>
              @for($i=0; $i<15; $i++)
                <tr>
                  <td class="td-center">{{ $i+1 }}</td>
                  <td>{{ $aspek[$i] ?? ('Aspek ' . ($i+1)) }}</td>
                  <td class="range">1=20 | 2=40 | 3=60 | 4=80 | 5=100</td>
                  <td class="td-center">
                    <span class="nilai-pill">{{ $nilai[$i] ?? '-' }}</span>
                  </td>
                </tr>
              @endfor
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
