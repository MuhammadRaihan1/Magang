@extends('layouts.mahasiswa')

@section('title', 'Penilaian')

@section('content')
<style>
  /* scoped only */
  .pen-page, .pen-page * { font-weight: 400 !important; }

  .pen-head{ margin-bottom: 16px; }
  .pen-title{
    margin:0;
    font-size:22px;
    color:#0f172a;
    font-weight:800 !important;
    letter-spacing:-.02em;
  }
  .pen-sub{ margin-top:6px; font-size:13px; color:#64748b; }

  .card-clean{
    width:100%;
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 1px 2px rgba(15,23,42,.06);
  }

  .info-row{
    padding:14px 16px;
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:space-between;
    gap:10px;
  }
  .muted{ color:#64748b; font-size:13px; }
  .muted b{ color:#0f172a; font-weight:800 !important; }

  /* summary */
  .sum-wrap{ padding:16px; }
  .sum-grid{
    display:grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap:12px;
  }
  .sum-box{
    border:1px solid #eef2f7;
    border-radius:12px;
    padding:12px 14px;
    background:#fff;
  }
  .sum-label{ color:#64748b; font-size:12px; }
  .sum-value{
    margin-top:6px;
    color:#0f172a;
    font-size:18px;
    font-weight:800 !important;
    font-variant-numeric: tabular-nums;
  }

  /* grade pill */
  .grade-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:46px;
    height:30px;
    padding:0 12px;
    border-radius:999px;
    font-size:12px;
    border:1px solid #e2e8f0;
    background:#f1f5f9;
    color:#0f172a;
    font-weight:800 !important;
  }
  .g-a{ background:#ecfdf5; border-color:#a7f3d0; color:#065f46; }
  .g-b{ background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8; }
  .g-c{ background:#fffbeb; border-color:#fde68a; color:#92400e; }
  .g-d{ background:#fef2f2; border-color:#fecaca; color:#991b1b; }
  .g-x{ background:#f1f5f9; border-color:#e2e8f0; color:#0f172a; }

  /* table wrapper */
  .table-wrap{ width:100%; overflow-x:auto; padding-bottom: 6px; }

  .nilai-table{
    width:100% !important;
    margin:0;
    table-layout: fixed;
  }
  .nilai-table th, .nilai-table td{
    font-size:13px;
    vertical-align:middle;
  }
  .nilai-table thead th{
    background:#f8fafc;
    color:#0f172a;
    text-align:center;
    border-bottom:1px solid #e5e7eb;
    padding:12px 14px;
    font-weight:800 !important;
  }
  .nilai-table tbody td{
    padding:12px 14px;
    border-top:1px solid #eef2f7;
    word-wrap: break-word;
  }
  .nilai-table tbody tr:hover{ background:#fbfdff; }

  .col-no{ width:60px; }
  .col-range{ width:280px; }   /* sedikit lebih lebar */
  .col-nilai{ width:160px; }   /* biar pill gak dempet */

  .range-left{
    text-align:left !important;
    padding-left:14px !important;
    white-space:nowrap;
    color:#64748b;
    font-size:12px;
  }

  .nilai-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:64px;
    height:32px;
    padding:0 14px;
    border-radius:999px;
    font-size:12px;
    border:1px solid #e2e8f0;
    background:#f1f5f9;
    color:#0f172a;
    font-weight:800 !important;
    font-variant-numeric: tabular-nums;
  }

  /* ======= TFOOT RAPİH + TIDAK DEMPET ======= */
  .nilai-table tfoot th,
  .nilai-table tfoot td{
    border:0 !important;
    background:#fff;
  }

  /* kasih jarak dari body ke tfoot */
  .nilai-table tfoot{
    border-top: 10px solid transparent; /* ruang visual */
  }

  /* jarak antar baris summary */
  .nilai-table tfoot tr th,
  .nilai-table tfoot tr td{
    padding: 6px 14px !important;
  }

  .sum-label-right{
    text-align:right;
    color:#64748b;
    font-size:12px;
    letter-spacing:.2px;
    font-weight:800 !important;
    padding-right: 18px !important; /* biar ga nempel */
  }
  .sum-value-right{
    text-align:right;
    color:#0f172a;
    font-variant-numeric: tabular-nums;
    font-size:14px;
    font-weight:800 !important;
    padding-right: 18px !important; /* biar ga nempel kanan */
  }

  /* footer actions bawah */
  .pen-footer{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    padding:18px 16px;               /* lebih lega */
    border-top:1px solid #eef2f7;
    background:#fff;
  }

  .btn-clean{
    border-radius:12px;
    padding:10px 16px;               /* lebih lega */
    border:1px solid #e5e7eb;
    background:#fff;
    color:#0f172a;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:10px;
    font-weight:800 !important;
  }
  .btn-clean:hover{
    background:#f8fafc;
    border-color:#d1d5db;
    color:#0f172a;
  }

  /* extra spacing antar card */
  .mb-3{ margin-bottom: 16px !important; }

  @media (max-width: 900px){
    .sum-grid{ grid-template-columns: 1fr; }
    .col-range{ width:240px; }
    .col-nilai{ width:150px; }
  }
</style>

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
    'Sikap terhadap petunjuk, kritik, atau anjuran pembimbing',
    'Pelaksanaan program keselamatan kerja',
    'Pemeliharaan keselamatan alat, bahan, dan lingkungan',
    'Kewajaran penampilan dan berpakaian',
    'Adaptasi dengan situasi dan kondisi tempat praktek',
  ];

  $nilaiArr = $penilaian->nilai ?? [];

  $grade = $penilaian->grade ?? null;
  $gradeClass = 'g-x';
  if (in_array($grade, ['A','A-'])) $gradeClass = 'g-a';
  elseif (in_array($grade, ['B+','B','B-'])) $gradeClass = 'g-b';
  elseif (in_array($grade, ['C+','C','C-'])) $gradeClass = 'g-c';
  elseif (in_array($grade, ['D','E'])) $gradeClass = 'g-d';
@endphp

<div class="pen-page container-fluid">

  <div class="pen-head">
    <h2 class="pen-title">Penilaian</h2>
    <div class="pen-sub">Lihat hasil penilaian dari supervisor.</div>
  </div>

  <div class="card-clean mb-3">
    <div class="info-row">
      <div class="muted">
        Nama: <b>{{ auth()->user()->name }}</b>
      </div>
      <div class="muted">
        Status: <b>{{ $penilaian ? 'Sudah dinilai' : 'Belum dinilai' }}</b>
      </div>
    </div>
  </div>

  @if(!$penilaian)
    <div class="card-clean">
      <div class="p-3">
        <div class="muted">Belum ada penilaian dari supervisor.</div>
      </div>
      <div class="pen-footer">
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn-clean">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
    </div>
  @else
    {{-- Ringkasan --}}
    <div class="card-clean mb-3">
      <div class="sum-wrap">
        <div class="sum-grid">
          <div class="sum-box">
            <div class="sum-label">Total Skor</div>
            <div class="sum-value">{{ $penilaian->total_skor ?? 0 }}</div>
          </div>

          <div class="sum-box">
            <div class="sum-label">Nilai Akhir</div>
            <div class="sum-value">{{ number_format($penilaian->nilai_akhir ?? 0, 2) }}</div>
          </div>

          <div class="sum-box">
            <div class="sum-label">Grade</div>
            <div class="sum-value" style="font-size:16px;">
              <span class="grade-pill {{ $gradeClass }}">{{ $grade ?? '-' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Detail 15 Aspek --}}
    <div class="card-clean">
      <div class="table-wrap">
        <table class="table table-bordered nilai-table">
          <thead>
            <tr>
              <th class="col-no">No</th>
              <th>ASPEK YANG DINILAI</th>
              <th class="col-range range-left">RANGE PENILAIAN</th>
              <th class="col-nilai">Nilai</th>
            </tr>
          </thead>

          <tbody>
            @foreach($aspek as $i => $nama)
              @php $v = $nilaiArr[$i] ?? '-'; @endphp
              <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $nama }}</td>
                <td class="range-left">1=20 | 2=40 | 3=60 | 4=80 | 5=100</td>
                <td class="text-center">
                  <span class="nilai-pill">{{ $v }}</span>
                </td>
              </tr>
            @endforeach
          </tbody>

          {{-- Summary bawah, lebih lega --}}
          <tfoot>
            <tr>
              <th colspan="3" class="sum-label-right">TOTAL SKOR</th>
              <th class="sum-value-right">{{ $penilaian->total_skor ?? 0 }}</th>
            </tr>
            <tr>
              <th colspan="3" class="sum-label-right">NILAI AKHIR</th>
              <th class="sum-value-right">{{ number_format($penilaian->nilai_akhir ?? 0, 2) }}</th>
            </tr>
            <tr>
              <th colspan="3" class="sum-label-right">GRADE</th>
              <th class="sum-value-right">{{ $penilaian->grade ?? '-' }}</th>
            </tr>
          </tfoot>
        </table>
      </div>

      {{-- tombol di bawah (lebih lega) --}}
      <div class="pen-footer">
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn-clean">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
    </div>
  @endif

</div>
@endsection
