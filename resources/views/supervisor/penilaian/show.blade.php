@extends('supervisor.layout')

@section('title','Detail Penilaian')

@section('content')
<style>
  .detail-wrap, .detail-wrap * { font-weight: 400 !important; }

  .page-title{ color:#0f172a; font-size:22px; margin:0; }
  .muted{ color:#64748b; }

  .card-clean{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    overflow:hidden;
    box-shadow: 0 1px 2px rgba(15,23,42,.06);
  }

  .pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    border:1px solid transparent;
    line-height:1;
    white-space:nowrap;
  }
  .pill-green{ background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
  .pill-gray { background:#f1f5f9; color:#0f172a; border-color:#e2e8f0; }

  .grade{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:46px;
    height:28px;
    padding:0 12px;
    border-radius:999px;
    font-size:12px;
    border:1px solid transparent;
  }
  .g-a{ background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
  .g-b{ background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
  .g-c{ background:#fffbeb; color:#92400e; border-color:#fde68a; }
  .g-d{ background:#fef2f2; color:#991b1b; border-color:#fecaca; }
  .g-x{ background:#f1f5f9; color:#0f172a; border-color:#e2e8f0; }

  .stat-grid{
    display:grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap:12px;
  }
  @media (max-width: 992px){
    .stat-grid{ grid-template-columns: 1fr; }
  }
  .stat{
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:14px;
    background:#fff;
  }
  .stat .label{ font-size:12px; color:#64748b; margin-bottom:6px; }
  .stat .value{ font-size:20px; color:#0f172a; font-variant-numeric: tabular-nums; }

  .tbl th, .tbl td{ vertical-align: middle; }
  .tbl thead th{
    background:#f8fafc;
    color:#0f172a;
    border-bottom:1px solid #e5e7eb;
    padding:12px 14px;
    font-size:13px;
  }
  .tbl tbody td{
    padding:12px 14px;
    border-top:1px solid #eef2f7;
    font-size:13px;
  }
  .range{ color:#64748b; font-size:12px; }
  .nilai-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:56px;
    padding:6px 10px;
    border-radius:10px;
    background:#eff6ff;
    color:#1d4ed8;
    border:1px solid #bfdbfe;
    font-size:12px;
    font-variant-numeric: tabular-nums;
  }

  .btn-clean{
    border-radius:10px;
    padding:8px 14px;
    border:1px solid #e5e7eb;
    background:#fff;
    color:#0f172a;
  }
  .btn-clean:hover{
    background:#f8fafc;
    border-color:#d1d5db;
    color:#0f172a;
  }
</style>

@php
  $arr = is_array($penilaian->nilai ?? null) ? $penilaian->nilai : [];

  $aspek = [
    "Penguasaan ilmu bidang studi (teori) penunjang praktek",
    "Keterampilan membaca gambar kerja / petunjuk",
    "Keterampilan menggunakan alat / instrumen praktek",
    "Kapasitas hasil praktek sesuai waktu yang disediakan",
    "Kualitas hasil praktek dibanding standar (tolak ukur)",
    "Kemampuan berpraktek secara mandiri",
    "Inisiatif meningkatkan hasil praktek",
    "Inisiatif menyelesaikan / mengatasi masalah",
    "Kerja sama dengan orang lain selama praktek",
    "Disiplin dan kehadiran di tempat praktek",
    "Sikap terhadap petunjuk, kritik, atau anjuran pembimbing",
    "Pelaksanaan program keselamatan kerja",
    "Pemeliharaan keselamatan alat, bahan, dan lingkungan",
    "Kewajaran penampilan dan berpakaian",
    "Tanggung jawab terhadap tugas",
  ];

  $grade = $penilaian->grade ?? '-';
  $gradeClass = 'g-x';
  if (in_array($grade, ['A','A-'])) $gradeClass = 'g-a';
  elseif (in_array($grade, ['B+','B','B-'])) $gradeClass = 'g-b';
  elseif (in_array($grade, ['C+','C','C-'])) $gradeClass = 'g-c';
  elseif (in_array($grade, ['D','E'])) $gradeClass = 'g-d';

  $hasNilai = count($arr) === 15;
  $statusText = $hasNilai ? 'Sudah dinilai' : 'Belum dinilai';
  $statusClass = $hasNilai ? 'pill-green' : 'pill-gray';

  // Pastikan skor tetap tampil walau kolom belum ada / kosong
  $totalSkor  = $penilaian->total_skor ?? array_sum($arr);
  $nilaiAkhir = $penilaian->nilai_akhir ?? (count($arr) ? round($totalSkor / 15, 2) : 0);
@endphp

<div class="detail-wrap container-fluid">

  {{-- Header --}}
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
      <h2 class="page-title mb-1">Detail Penilaian</h2>
      <div class="muted">
        <a href="{{ route('supervisor.penilaian.index') }}" class="text-decoration-none">Penilaian</a>
        <span class="mx-1">/</span>
        <span>Detail</span>
      </div>
    </div>
  </div>

  {{-- Info Mahasiswa --}}
  <div class="card-clean mb-3">
    <div class="p-3 d-flex flex-wrap justify-content-between align-items-start gap-3">
      <div>
        <div class="muted" style="font-size:12px;">Mahasiswa</div>
        <div style="color:#0f172a; font-size:16px; margin-top:2px;">
          {{ $mahasiswa->name }}
        </div>
      </div>

      <div class="text-end">
        <div class="muted" style="font-size:12px;">Grade</div>
        <div class="mt-1">
          <span class="grade {{ $gradeClass }}">{{ $grade }}</span>
        </div>
        <div class="mt-2">
          <span class="pill {{ $statusClass }}">{{ $statusText }}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Ringkasan Skor --}}
  <div class="stat-grid mb-3">
    <div class="stat">
      <div class="label">TOTAL SKOR</div>
      <div class="value">{{ (int)$totalSkor }}</div>
    </div>
    <div class="stat">
      <div class="label">NILAI AKHIR</div>
      <div class="value">{{ number_format((float)$nilaiAkhir, 2) }}</div>
    </div>
    <div class="stat">
      <div class="label">TANGGAL</div>
      <div class="value" style="font-size:16px;">
        {{ $penilaian->tanggal ?? '-' }}
      </div>
    </div>
  </div>

  {{-- Detail 15 Aspek (seperti create: ada nama aspek + range + nilai) --}}
  <div class="card-clean">
    <div class="p-3 border-bottom" style="border-color:#e5e7eb;">
      <div style="color:#0f172a;">Detail 15 Aspek</div>
      <div class="muted" style="font-size:12px;">Rincian nilai per aspek</div>
    </div>

    <div class="p-0">
      <div class="table-responsive">
        <table class="table tbl mb-0">
          <thead>
            <tr>
              <th style="width:70px;" class="text-center">No</th>
              <th>ASPEK YANG DINILAI</th>
              <th style="width:220px;">RANGE PENILAIAN</th>
              <th style="width:160px;" class="text-center">Nilai</th>
            </tr>
          </thead>
          <tbody>
            @foreach($aspek as $i => $label)
              @php
                $v = $arr[$i] ?? null;
              @endphp
              <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $label }}</td>
                <td class="range">1=20 | 2=40 | 3=60 | 4=80 | 5=100</td>
                <td class="text-center">
                  @if($v !== null && $v !== '')
                    <span class="nilai-badge">{{ $v }}</span>
                  @else
                    <span class="pill pill-gray">-</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="p-3 border-top d-flex justify-content-end" style="border-color:#e5e7eb;">
      <a href="{{ route('supervisor.penilaian.index') }}" class="btn btn-clean">Kembali</a>
    </div>
  </div>

</div>
@endsection
