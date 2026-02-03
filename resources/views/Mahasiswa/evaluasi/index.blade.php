@extends('layouts.mahasiswa')

@section('title', 'Hasil Evaluasi')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* PAGE */
  .ev-page{
    padding:24px;
    width:100%;
  }

  /* CARD */
  .ev-card{
    width:100%;
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 22px 45px rgba(15,23,42,.08);
    overflow:hidden;
  }

  /* HEADER */
  .ev-topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:18px;
    padding:22px 26px;
    border-bottom:1px solid #e5e7eb;
    background:#fff;
  }

  .ev-title{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:#0f172a;
    letter-spacing:-.02em;
  }

  .ev-subtitle{
    margin-top:6px;
    font-size:14px;
    color:#64748b;
    font-weight:400;
  }

  .ev-actions{
    display:flex;
    gap:12px;
    align-items:center;
    flex-wrap:wrap;
  }

  /* SEARCH */
  .ev-search{
    position:relative;
    min-width:280px;
  }

  .ev-search input{
    width:100%;
    height:40px;
    border-radius:999px;
    border:1px solid #e5e7eb;
    padding:0 16px 0 42px;
    font-size:14px;
  }

  .ev-search input:focus{
    outline:none;
    border-color:#94a3b8;
    box-shadow:0 0 0 .2rem rgba(148,163,184,.25);
  }

  .ev-search svg{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    width:16px;
    color:#94a3b8;
  }

  /* ALERT */
  .ev-alert{
    margin:16px 26px 0;
    padding:14px 18px;
    border-radius:14px;
    background:#ecfeff;
    color:#0f172a;
    border-left:6px solid #2563eb;
    font-size:14px;
    font-weight:600;
  }

  /* TABLE */
  .ev-table-wrap{
    overflow-x:auto;
  }

  .ev-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    min-width:900px;
  }

  thead tr{
    background: linear-gradient(
      180deg,
      #eef2ff 0%,
      #e0e7ff 100%
    );
  }

  thead th{
    padding:16px;
    font-size:12.5px;
    font-weight:800;
    color:#1e293b;
    text-transform:uppercase;
    letter-spacing:.08em;
  }

  thead th:first-child{ border-top-left-radius:20px; }
  thead th:last-child{ border-top-right-radius:20px; }

  tbody td{
    padding:18px;
    border-top:1px solid #e5e7eb;
    font-size:14px;
    font-weight:400;
    color:#0f172a;
    vertical-align:middle;
  }

  tbody tr:hover{
    background:#f8fafc;
  }

  .ev-muted{ color:#64748b; }
  .ev-name{ font-weight:500; color:#0f172a; }

  /* BADGE */
  .ev-badge{
    padding:6px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    border:1px solid transparent;
    background:#f1f5f9;
    color:#475569;
    border-color:#e2e8f0;
    white-space:nowrap;
  }

  .ev-link{
    font-weight:700;
    color:#2563eb;
    text-decoration:none;
  }
  .ev-link:hover{text-decoration:underline;}

  /* FOOTER */
  .ev-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 26px;
    font-size:13px;
    color:#64748b;
  }

  .ev-pagination{
    padding:0 26px 22px;
  }
</style>

@php
  function evSupervisorName($supervisor) {
      if (is_null($supervisor)) return '-';

      if (is_object($supervisor)) {
          return $supervisor->name ?? (method_exists($supervisor, '__toString') ? (string)$supervisor : '-');
      }

      if (is_array($supervisor)) {
          return $supervisor['name'] ?? '-';
      }

      if (is_string($supervisor)) {
          $decoded = json_decode($supervisor, true);
          if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
              return $decoded['name'] ?? '-';
          }
          return $supervisor ?: '-';
      }

      return '-';
  }
@endphp

<div class="ev-page">
  <div class="ev-card">

    {{-- HEADER --}}
    <div class="ev-topbar">
      <div>
        <h1 class="ev-title">Hasil Evaluasi</h1>
        <p class="ev-subtitle">Daftar evaluasi dari supervisor dan nilai yang diberikan</p>
      </div>

      <div class="ev-actions">
        <div class="ev-search">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
            <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <input id="evSearch" type="text" placeholder="Cari tanggal, supervisor, atau nilai..." />
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="ev-alert">{{ session('success') }}</div>
    @endif

    {{-- TABLE --}}
    <div class="ev-table-wrap">
      <table class="ev-table" id="evTable">
        <thead>
          <tr>
            <th style="width:80px;">No</th>
            <th style="width:180px;">Tanggal</th>
            <th>Supervisor</th>
            <th style="width:160px;">Nilai</th>
            <th style="width:120px;">Detail</th>
          </tr>
        </thead>

        <tbody>
          @forelse($evaluasis as $i => $e)
            @php
              $no = method_exists($evaluasis, 'firstItem') && $evaluasis->firstItem()
                    ? $evaluasis->firstItem() + $i
                    : $i + 1;

              $tgl = optional($e->tanggal)->format('d-m-Y') ?? optional($e->created_at)->format('d-m-Y') ?? '-';

              $supName = evSupervisorName($e->supervisor ?? null);

              $nilai = $e->nilai;
              $nilaiLabel = ($nilai === null || $nilai === '' || $nilai === '-') ? '-' : $nilai;
            @endphp

            <tr>
              <td class="ev-muted">{{ $no }}</td>
              <td>{{ $tgl }}</td>
              <td class="ev-name">{{ $supName }}</td>
              <td><span class="ev-badge">{{ $nilaiLabel }}</span></td>
              <td>
                <a class="ev-link" href="{{ route('mahasiswa.evaluasi.show', $e->id) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center ev-muted py-4">
                Belum ada evaluasi dari supervisor.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="ev-footer">
      <span class="ev-muted">
        Total data: {{ method_exists($evaluasis, 'total') ? $evaluasis->total() : $evaluasis->count() }}
      </span>
      <span class="ev-muted">{{ now()->format('d-m-Y H:i') }}</span>
    </div>

    <div class="ev-pagination">
      {{ $evaluasis->links() }}
    </div>

  </div>
</div>

<script>
  (function () {
    const input = document.getElementById('evSearch');
    const table = document.getElementById('evTable');
    if (!input || !table) return;

    input.addEventListener('input', function () {
      const q = this.value.toLowerCase().trim();
      const rows = table.querySelectorAll('tbody tr');

      rows.forEach(row => {
        if (row.querySelector('.ev-empty')) return;
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
      });
    });
  })();
</script>
@endsection
