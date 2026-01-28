@extends('supervisor.layout')

@section('title', 'Penilaian Mahasiswa')

@section('content')
<style>
  .pen-wrap, .pen-wrap *{
    font-weight: 400 !important;
  }

  /* Layout */
  .page-title{ color:#0f172a; }

  /* Table */
  .pen-wrap{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    overflow:hidden;
    box-shadow: 0 1px 2px rgba(15,23,42,.06);
  }
  .pen-table{ margin:0; }
  .pen-table th, .pen-table td{ vertical-align: middle; }
  .pen-table thead th{
    background:#f8fafc;
    color:#0f172a;
    border-bottom:1px solid #e5e7eb;
    padding:14px 16px;
    font-size:13px;
  }
  .pen-table tbody td{
    padding:16px;
    border-top:1px solid #eef2f7;
  }
  .pen-table tbody tr:hover{ background:#fbfdff; }

  /* Name */
  .mhs-name{ color:#0f172a; line-height:1.2; }

  /* Hasil */
  .hasil-inline{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
  }
  .hasil-left{
    display:flex;
    align-items:baseline;
    gap:8px;
    min-width:0;
  }
  .hasil-label{
    font-size:12px;
    color:#64748b;
    white-space:nowrap;
  }
  .hasil-value{
    font-size:14px;
    color:#0f172a;
    font-variant-numeric: tabular-nums;
    white-space:nowrap;
  }

  /* Badges */
  .badge-pill{
    display:inline-flex;
    align-items:center;
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    border:1px solid transparent;
    line-height:1;
    white-space:nowrap;
  }
  .badge-muted{ background:#f1f5f9; color:#0f172a; border-color:#e2e8f0; }

  .badge-grade{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:42px;
    height:26px;
    padding:0 10px;
    border-radius:999px;
    font-size:12px;
    border:1px solid transparent;
  }
  .g-a{ background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
  .g-b{ background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
  .g-c{ background:#fffbeb; color:#92400e; border-color:#fde68a; }
  .g-d{ background:#fef2f2; color:#991b1b; border-color:#fecaca; }
  .g-x{ background:#f1f5f9; color:#0f172a; border-color:#e2e8f0; }

  /* Aksi */
  .aksi-group{
    display:inline-flex;
    gap:8px;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;
  }
  .btn-clean{
    border-radius:10px;
    padding:8px 14px;
    border:1px solid #e5e7eb;
    background:#fff;
    color:#0f172a;
    text-decoration:none;
  }
  .btn-clean:hover{
    background:#f8fafc;
    border-color:#d1d5db;
    color:#0f172a;
  }
  .btn-clean-primary{
    border-radius:10px;
    padding:8px 14px;
  }
</style>

<div class="mb-3">
  <h2 class="page-title mb-1">Penilaian Mahasiswa</h2>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="pen-wrap">
  <div class="table-responsive">
    <table class="table pen-table">
      <thead>
        <tr>
          <th style="width:70px" class="text-center">No</th>
          <th>Mahasiswa</th>
          <th>Email</th>
          <th style="width:260px">Hasil</th>
          <th style="width:200px" class="text-center">Aksi</th>
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

            <td>
              <div class="mhs-name">{{ $mhs->name }}</div>
            </td>

            <td class="text-muted">{{ $mhs->email }}</td>

            <td>
              @if($p)
                <div class="hasil-inline">
                  <div class="hasil-left">
                    <span class="hasil-label">Nilai</span>
                    <span class="hasil-value">{{ number_format($p->nilai_akhir ?? 0, 2) }}</span>
                  </div>
                  <span class="badge-grade {{ $gradeClass }}">{{ $grade ?? '-' }}</span>
                </div>
              @else
                <span class="badge-pill badge-muted">Belum dinilai</span>
              @endif
            </td>

            <td class="text-center">
              <div class="aksi-group">
                @if($p)
                  <a class="btn btn-clean" href="{{ route('supervisor.penilaian.show', $mhs->id) }}">Detail</a>
                  <a class="btn btn-clean" href="{{ route('supervisor.penilaian.edit', $mhs->id) }}">Edit</a>
                @else
                  <a class="btn btn-primary btn-clean-primary" href="{{ route('supervisor.penilaian.create', $mhs->id) }}">Isi Penilaian</a>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              Data mahasiswa tidak ditemukan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
