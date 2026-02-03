@extends('supervisor.layout')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* PAGE HEADER */
  .page-header{
    margin-bottom:20px;
  }

  .page-header h1{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:#0f172a;
  }

  .page-header p{
    margin-top:6px;
    color:#64748b;
    font-size:15px;
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
    width:80px;
    text-align:center;
  }

  thead th:last-child{
    border-top-right-radius:20px;
    text-align:center;
    width:220px;
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

  .td-name{
    font-weight:700;
  }

  .text-muted{
    color:#64748b;
  }

  /* STATUS */
  .pill-soft{
    display:inline-block;
    padding:6px 14px;
    border-radius:999px;
    background:#f1f5f9;
    color:#475569;
    font-size:13px;
    font-weight:600;
  }

  /* BUTTON */
  .btn-action{
    padding:7px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    transition:.15s ease;
    display:inline-block;
  }

  .btn-primary-soft{
    background:#2563eb;
    color:#fff;
  }

  .btn-primary-soft:hover{
    background:#1e40af;
    color:#fff;
  }

  .btn-ghost{
    background:#fff;
    color:#2563eb;
    border:2px solid #2563eb;
  }

  .btn-ghost:hover{
    background:#2563eb;
    color:#fff;
  }

  @media(max-width:768px){
    thead th,
    tbody td{
      padding:14px;
      font-size:14px;
    }

    .page-header h1{
      font-size:24px;
    }
  }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
  <h1>Evaluasi Mahasiswa</h1>
  <p>Daftar mahasiswa bimbingan dan hasil evaluasinya</p>
</div>

@if(session('success'))
  <div class="alert-success">
    {{ session('success') }}
  </div>
@endif

{{-- TABLE --}}
<div class="table-card">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mahasiswa</th>
        <th>Email</th>
        <th style="width:200px; text-align:center;">Hasil</th>
        <th style="width:220px; text-align:center;">Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse($mahasiswas as $mhs)
        @php
          $ev = $evaluasiMap[$mhs->id] ?? null;
          $nilai = $ev?->nilai;
        @endphp

        <tr>
          <td class="text-center text-muted">{{ $loop->iteration }}</td>

          <td class="td-name">{{ $mhs->name }}</td>

          <td class="text-muted">{{ $mhs->email }}</td>

          <td class="text-center">
            @if($ev)
              <span class="text-muted me-1">Nilai</span>
              <span>{{ number_format((float) $nilai, 2) }}</span>
            @else
              <span class="pill-soft">Belum dinilai</span>
            @endif
          </td>

          <td class="text-center">
            <a href="{{ route('supervisor.evaluasi.create', $mhs->id) }}"
               class="btn-action {{ $ev ? 'btn-ghost' : 'btn-primary-soft' }}">
              {{ $ev ? 'Edit Evaluasi' : 'Isi Evaluasi' }}
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center py-5 text-muted">
            Belum ada mahasiswa bimbingan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
