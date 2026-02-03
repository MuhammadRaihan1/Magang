@extends('layouts.mahasiswa')

@section('title', 'Laporan Kegiatan')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* PAGE */
  .keg-page{
    padding:24px;
    width:100%;
  }

  /* CARD */
  .keg-card{
    width:100%;
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 22px 45px rgba(15,23,42,.08);
    overflow:hidden;
  }

  /* HEADER (PUTIH, NO BIRU) */
  .keg-topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:18px;
    padding:22px 26px;
    border-bottom:1px solid #e5e7eb;
    background:#fff;
  }

  .keg-title{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:#0f172a;
    letter-spacing:-.02em;
  }

  .keg-subtitle{
    margin-top:6px;
    font-size:14px;
    color:#64748b;
    font-weight:400;
  }

  .keg-actions{
    display:flex;
    gap:12px;
    align-items:center;
    flex-wrap:wrap;
  }

  /* SEARCH */
  .keg-search{
    position:relative;
    min-width:280px;
  }

  .keg-search input{
    width:100%;
    height:40px;
    border-radius:999px;
    border:1px solid #e5e7eb;
    padding:0 16px 0 42px;
    font-size:14px;
  }

  .keg-search input:focus{
    outline:none;
    border-color:#94a3b8;
    box-shadow:0 0 0 .2rem rgba(148,163,184,.25);
  }

  .keg-search svg{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    width:16px;
    color:#94a3b8;
  }

  /* BUTTON */
  .keg-btn{
    height:40px;
    padding:0 22px;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    transition:.15s ease;
  }

  .keg-btn--tambah{
    background:#2563eb;
    color:#fff;
  }
  .keg-btn--tambah:hover{background:#1e40af;}

  .keg-btn--cetak{
    background:#fff;
    color:#2563eb;
    border:2px solid #2563eb;
  }
  .keg-btn--cetak:hover{
    background:#2563eb;
    color:#fff;
  }

  /* ALERT */
  .keg-alert{
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
  .keg-table-wrap{
    overflow-x:auto;
  }

  table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    min-width:900px;
  }

  /* === BIRU DIPINDAH KE SINI & DIPUDARKAN === */
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

  .keg-muted{ color:#64748b; }
  .keg-time{ font-variant-numeric: tabular-nums; }
  .keg-activity{ font-weight:500; }

  /* BADGE */
  .keg-badge{
    padding:6px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    border:1px solid transparent;
  }

  .keg-badge--neutral{
    background:#f1f5f9;
    color:#475569;
    border-color:#e2e8f0;
  }

  .keg-badge--success{
    background:#ecfdf5;
    color:#065f46;
    border-color:#a7f3d0;
  }

  .keg-badge--danger{
    background:#fef2f2;
    color:#991b1b;
    border-color:#fecaca;
  }

  .keg-link{
    font-weight:700;
    color:#2563eb;
    text-decoration:none;
  }
  .keg-link:hover{text-decoration:underline;}

  /* FOOTER */
  .keg-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 26px;
    font-size:13px;
    color:#64748b;
  }

  .keg-pagination{
    padding:0 26px 22px;
  }
</style>

<div class="keg-page">
  <div class="keg-card">

    {{-- HEADER --}}
    <div class="keg-topbar">
      <div>
        <h1 class="keg-title">Laporan Kegiatan</h1>
        <p class="keg-subtitle">Daftar aktivitas harian dan status verifikasi supervisor</p>
      </div>

      <div class="keg-actions">
        <div class="keg-search">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
            <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <input id="kegSearch" type="text" placeholder="Cari kegiatan..." />
        </div>

        <a href="{{ route('mahasiswa.kegiatan.create') }}" class="keg-btn keg-btn--tambah">Tambah</a>
        <a href="{{ route('mahasiswa.kegiatan.print') }}" class="keg-btn keg-btn--cetak">Cetak</a>
      </div>
    </div>

    @if(session('success'))
      <div class="keg-alert">{{ session('success') }}</div>
    @endif

    {{-- TABLE --}}
    <div class="keg-table-wrap">
      <table id="kegTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Masuk - Pulang</th>
            <th>Aktivitas</th>
            <th>Verifikasi</th>
            <th>Detail</th>
          </tr>
        </thead>

        <tbody>
          @forelse($kegiatans as $i => $k)
            @php
              $status = strtolower($k->status ?? '');
              if($status == 'approved'){ $badge='keg-badge--success'; $label='Approved'; }
              elseif($status == 'rejected'){ $badge='keg-badge--danger'; $label='Rejected'; }
              else{ $badge='keg-badge--neutral'; $label='Pending'; }

              $no = method_exists($kegiatans,'firstItem') && $kegiatans->firstItem()
                    ? $kegiatans->firstItem() + $i : $i + 1;
            @endphp

            <tr>
              <td class="keg-muted">{{ $no }}</td>
              <td>{{ optional($k->tanggal)->format('d-m-Y') }}</td>
              <td class="keg-time">{{ substr($k->jam_masuk,0,5) }} — {{ substr($k->jam_pulang,0,5) }}</td>
              <td class="keg-activity">{{ \Illuminate\Support\Str::limit($k->aktivitas,60) }}</td>
              <td><span class="keg-badge {{ $badge }}">{{ $label }}</span></td>
              <td><a class="keg-link" href="{{ route('mahasiswa.kegiatan.show',$k->id) }}">Detail</a></td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center keg-muted py-4">
                Belum ada laporan kegiatan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="keg-footer">
      <span>Total data: {{ method_exists($kegiatans,'total') ? $kegiatans->total() : $kegiatans->count() }}</span>
      <span>{{ now()->format('d-m-Y H:i') }}</span>
    </div>

    <div class="keg-pagination">
      {{ $kegiatans->links() }}
    </div>

  </div>
</div>

<script>
  document.getElementById('kegSearch')?.addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#kegTable tbody tr').forEach(tr=>{
      tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  });
</script>
@endsection
