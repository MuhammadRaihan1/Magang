@extends('supervisor.layout')

@section('title', 'Penilaian Mahasiswa')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* PAGE HEADER */
  .page-header{
    margin-bottom:18px;
  }

  .page-header h2{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:#0f172a;
  }

  /* ALERT */
  .alert-success{
    background:#ecfeff;
    color:#0f172a;
    border-left:6px solid #2563eb;
    padding:14px 18px;
    border-radius:12px;
    margin-bottom:20px;
    font-weight:600;
  }

  /* TABLE CARD */
  .table-card{
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 22px 45px rgba(15,23,42,.08);
    padding:0;
  }

  table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
  }

  /* HEADER TABLE */
  thead tr{
    background:#c7d2fe;
  }

  thead th{
    padding:18px;
    font-size:13px;
    font-weight:900;
    color:#1e293b;
    text-transform:uppercase;
    letter-spacing:.6px;
    text-align:left;
  }

  thead th:first-child{
    border-top-left-radius:20px;
    width:70px;
    text-align:center;
  }

  thead th:last-child{
    border-top-right-radius:20px;
    width:200px;
    text-align:center;
  }

  tbody td{
    padding:18px;
    font-size:15px;
    color:#0f172a;
    border-top:1px solid #e5e7eb;
    vertical-align:middle;
  }

  tbody tr:hover{
    background:#f8fafc;
  }

  .mhs-name{
    font-weight:700;
  }

  .text-muted{
    color:#64748b;
  }

  /* HASIL */
  .hasil-inline{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
  }

  .hasil-label{
    font-size:13px;
    color:#64748b;
  }

  .hasil-value{
    font-size:15px;
    color:#0f172a;
  }

  /* BADGE */
  .badge-grade{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:42px;
    height:26px;
    padding:0 12px;
    border-radius:999px;
    font-size:12px;
    border:1px solid #e2e8f0;
    font-weight:600;
    background:transparent;
  }

  /* A TANPA BACKGROUND */
  .g-a{
    background:transparent;
    color:#065f46;
    border-color:#a7f3d0;
  }

  .g-b{ background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
  .g-c{ background:#fffbeb; color:#92400e; border-color:#fde68a; }
  .g-d{ background:#fef2f2; color:#991b1b; border-color:#fecaca; }
  .g-x{ background:#f1f5f9; color:#0f172a; border-color:#e2e8f0; }

  .badge-muted{
    padding:6px 14px;
    border-radius:999px;
    background:#f1f5f9;
    color:#475569;
    font-size:13px;
    font-weight:600;
  }

  /* ACTION */
  .aksi-group{
    display:flex;
    justify-content:center;
    gap:10px;
    flex-wrap:wrap;
  }

  .btn-action{
    padding:7px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    transition:.15s ease;
    border:2px solid #2563eb;
    color:#2563eb;
    background:#fff;
  }

  .btn-action:hover{
    background:#2563eb;
    color:#fff;
  }

  .btn-primary-soft{
    padding:7px 20px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
  }

  .btn-primary-soft:hover{
    background:#1e40af;
    color:#fff;
  }

  @media(max-width:768px){
    thead th,
    tbody td{
      padding:14px;
      font-size:14px;
    }

    .page-header h2{
      font-size:24px;
    }
  }
</style>

<div class="page-header">
  <h2>Penilaian Akhir Mahasiswa</h2>
</div>

@if(session('success'))
  <div class="alert-success">
    {{ session('success') }}
  </div>
@endif

<div class="table-card">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mahasiswa</th>
        <th>Email</th>
        <th style="width:260px;">Hasil</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse($mahasiswa as $i => $mhs)
        @php
          $p = $mhs->penilaianTerakhir;
          $grade = $p->grade ?? null;

          $gradeClass = 'g-x';
          if (in_array($grade, ['A','A-'])) $gradeClass = 'g-a';
          elseif (in_array($grade, ['B+','B','B-'])) $gradeClass = 'g-b';
          elseif (in_array($grade, ['C+','C','C-'])) $gradeClass = 'g-c';
          elseif (in_array($grade, ['D','E'])) $gradeClass = 'g-d';
        @endphp

        <tr>
          <td class="text-center text-muted">{{ $i + 1 }}</td>
          <td class="mhs-name">{{ $mhs->name }}</td>
          <td class="text-muted">{{ $mhs->email }}</td>
          <td>
            @if($p)
              <div class="hasil-inline">
                <div>
                  <span class="hasil-label">Nilai</span>
                  <span class="hasil-value">{{ number_format($p->nilai_akhir ?? 0, 2) }}</span>
                </div>
                <span class="badge-grade {{ $gradeClass }}">{{ $grade ?? '-' }}</span>
              </div>
            @else
              <span class="badge-muted">Belum dinilai</span>
            @endif
          </td>
          <td class="text-center">
            <div class="aksi-group">
              @if($p)
                <a class="btn-action" href="{{ route('supervisor.penilaian.show', $mhs->id) }}">Detail</a>
                <a class="btn-action" href="{{ route('supervisor.penilaian.edit', $mhs->id) }}">Edit</a>
              @else
                <a class="btn-primary-soft" href="{{ route('supervisor.penilaian.create', $mhs->id) }}">Isi Penilaian</a>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center py-4 text-muted">
            Data mahasiswa tidak ditemukan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
