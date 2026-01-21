@extends('layouts.mahasiswa')

@section('title', 'Hasil Evaluasi')

@section('content')
<style>
  /* ============================
     Scoped untuk halaman evaluasi
     Tidak mengubah sidebar/menu
     ============================ */

  .ev-page { padding: 18px; }

  .ev-card{
    background:#fff;
    border:1px solid #eef1f6;
    border-radius:14px;
    box-shadow:0 10px 26px rgba(16,24,40,.08);
    overflow:hidden;
  }

  .ev-topbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:16px;
    padding:18px 18px 14px;
    border-bottom:1px solid #eef1f6;
    background:linear-gradient(180deg,#ffffff 0%, #fbfcff 100%);
  }

  .ev-title{
    margin:0;
    font-size:22px;
    font-weight:800;
    color:#101828;
    letter-spacing:-.02em;
  }

  .ev-subtitle{
    margin:6px 0 0;
    font-size:13px;
    color:#667085;
  }

  .ev-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    justify-content:flex-end;
  }

  .ev-search{ position:relative; min-width:260px; }

  .ev-search input{
    width:100%;
    height:38px;
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:0 12px 0 36px;
    outline:none;
    font-size:13px;
    color:#101828;
    background:#fff;
  }

  .ev-search input:focus{
    border-color:#c7d2fe;
    box-shadow:0 0 0 4px rgba(99,102,241,.12);
  }

  .ev-search svg{
    position:absolute;
    left:10px;
    top:50%;
    transform:translateY(-50%);
    width:16px; height:16px;
    color:#98a2b3;
  }

  .ev-alert{
    margin:14px 18px 0;
    padding:12px 14px;
    border-radius:12px;
    border:1px solid #abefc6;
    background:#ecfdf3;
    color:#027a48;
    font-size:13px;
    font-weight:600;
  }

  .ev-table-wrap{ width:100%; overflow-x:auto; }

  .ev-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    min-width:820px;
  }

  .ev-table thead th{
    text-align:left;
    font-size:11px;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:#667085;
    background:#fbfcff;
    padding:12px 16px;
    border-bottom:1px solid #eef1f6;
    position:sticky;
    top:0;
    z-index:1;
  }

  .ev-table tbody td{
    padding:14px 16px;
    border-bottom:1px solid #f0f2f6;
    font-size:13px;
    color:#101828;
    vertical-align:middle;
  }

  .ev-table tbody tr:nth-child(even){ background:#fcfcfd; }
  .ev-table tbody tr:hover{ background:#f9fafb; }

  .ev-muted{ color:#667085; }

  .ev-name{ font-weight:700; color:#101828; }

  .ev-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
    border:1px solid transparent;
    white-space:nowrap;
  }

  .ev-badge--neutral{ background:#f2f4f7; color:#344054; border-color:#e4e7ec; }
  .ev-badge--success{ background:#ecfdf3; color:#027a48; border-color:#abefc6; }
  .ev-badge--warning{ background:#fffaeb; color:#b54708; border-color:#fedf89; }

  .ev-link{
    color:#111827;
    font-weight:800;
    text-decoration:none;
    border-bottom:1px dashed #cbd5e1;
    padding-bottom:1px;
  }
  .ev-link:hover{ opacity:.85; }

  .ev-empty{
    text-align:center;
    color:#667085;
    padding:18px 16px;
  }

  .ev-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    padding:12px 16px;
    background:#fff;
  }

  .ev-pagination{
    padding: 0 6px 16px 6px;
  }
</style>

@php
  /**
   * Helper kecil buat nampilin nama supervisor dengan aman:
   * - Relasi object: $e->supervisor->name
   * - JSON/array: $e->supervisor['name'] / $e->supervisor->name
   * - String: langsung tampil
   */
  function evSupervisorName($supervisor) {
      if (is_null($supervisor)) return '-';

      // kalau relasi / object
      if (is_object($supervisor)) {
          return $supervisor->name ?? (method_exists($supervisor, '__toString') ? (string)$supervisor : '-');
      }

      // kalau array (hasil cast json)
      if (is_array($supervisor)) {
          return $supervisor['name'] ?? '-';
      }

      // kalau string
      if (is_string($supervisor)) {
          // kalau string-nya JSON, coba decode ambil name
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

    <div class="ev-topbar">
      <div>
        <h1 class="ev-title">Hasil Evaluasi</h1>
        <p class="ev-subtitle">Daftar evaluasi dari supervisor dan nilai yang diberikan.</p>
      </div>

      <div class="ev-actions">
        <div class="ev-search">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
            <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <input id="evSearch" type="text" placeholder="Cari tanggal / supervisor / nilai..." />
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="ev-alert">{{ session('success') }}</div>
    @endif

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

              // pakai created_at / tanggal kalau ada
              $tgl = optional($e->tanggal)->format('d-m-Y') ?? optional($e->created_at)->format('d-m-Y') ?? '-';

              // ambil supervisor name aman
              // prioritas: relasi supervisor (kalau ada), kalau tidak ada pakai attribute supervisor
              $supName = evSupervisorName($e->supervisor ?? null);

              // nilai badge
              $nilai = $e->nilai;
              if ($nilai === null || $nilai === '' || $nilai === '-') {
                  $badgeClass = 'ev-badge--neutral';
                  $nilaiLabel = '-';
              } else {
                  if (is_numeric($nilai) && $nilai >= 85) $badgeClass = 'ev-badge--success';
                  elseif (is_numeric($nilai) && $nilai >= 70) $badgeClass = 'ev-badge--warning';
                  else $badgeClass = 'ev-badge--neutral';

                  $nilaiLabel = $nilai;
              }
            @endphp

            <tr>
              <td class="ev-muted">{{ $no }}</td>
              <td>{{ $tgl }}</td>
              <td class="ev-name">{{ $supName }}</td>
              <td><span class="ev-badge {{ $badgeClass }}">{{ $nilaiLabel }}</span></td>
              <td>
                <a class="ev-link" href="{{ route('mahasiswa.evaluasi.show', $e->id) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="ev-empty">Belum ada evaluasi dari supervisor.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="ev-footer">
      <span class="ev-muted">
        Total data: {{ method_exists($evaluasis, 'total') ? $evaluasis->total() : $evaluasis->count() }}
      </span>
      <span class="ev-muted">Terakhir diperbarui: {{ now()->format('d-m-Y H:i') }}</span>
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
