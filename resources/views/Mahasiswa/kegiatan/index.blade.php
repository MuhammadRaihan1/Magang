@extends('layouts.mahasiswa')

@section('title', 'Laporan Kegiatan')

@section('content')
<style>
  /* ===========================================
     Scoped styles: hanya untuk halaman kegiatan
     Tidak mengubah sidebar/menu layout
     =========================================== */

  .keg-page{
    padding: 18px;
  }

  .keg-card{
    background:#fff;
    border: 1px solid #eef1f6;
    border-radius: 14px;
    box-shadow: 0 10px 26px rgba(16,24,40,.08);
    overflow: hidden;
  }

  .keg-topbar{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap: 16px;
    padding: 18px 18px 14px 18px;
    border-bottom: 1px solid #eef1f6;
    background: linear-gradient(180deg,#ffffff 0%, #fbfcff 100%);
  }

  .keg-title{
    margin:0;
    font-size: 22px;
    font-weight: 800;
    color:#101828;
    letter-spacing: -0.02em;
  }

  .keg-subtitle{
    margin: 6px 0 0 0;
    font-size: 13px;
    color:#667085;
  }

  .keg-actions{
    display:flex;
    align-items:center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content:flex-end;
  }

  .keg-search{
    position: relative;
    min-width: 260px;
  }

  .keg-search input{
    width:100%;
    height: 38px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 0 12px 0 36px;
    outline: none;
    font-size: 13px;
    color:#101828;
    background:#fff;
  }

  .keg-search input:focus{
    border-color:#c7d2fe;
    box-shadow: 0 0 0 4px rgba(99,102,241,.12);
  }

  .keg-search svg{
    position:absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    color: #98a2b3;
  }

  .keg-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    height: 38px;
    padding: 0 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid transparent;
    transition: .15s ease;
    user-select:none;
    cursor:pointer;
  }

  .keg-btn--tambah{
    background:#111827;
    color:#fff;
    border-color:#111827;
  }
  .keg-btn--tambah:hover{opacity:.92;}

  .keg-btn--cetak{
    background:#fff;
    color:#111827;
    border-color:#e5e7eb;
  }
  .keg-btn--cetak:hover{background:#f9fafb;}

  .keg-alert{
    margin: 14px 0 0 0;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #abefc6;
    background: #ecfdf3;
    color: #027a48;
    font-size: 13px;
    font-weight: 600;
  }

  .keg-table-wrap{
    width: 100%;
    overflow-x: auto;
  }

  .keg-table{
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 860px;
  }

  .keg-table thead th{
    text-align:left;
    font-size: 11px;
    letter-spacing: .08em;
    text-transform: uppercase;
    color:#667085;
    background:#fbfcff;
    padding: 12px 16px;
    border-bottom: 1px solid #eef1f6;
    position: sticky;
    top: 0;
    z-index: 1;
  }

  .keg-table tbody td{
    padding: 14px 16px;
    border-bottom: 1px solid #f0f2f6;
    font-size: 13px;
    color:#101828;
    vertical-align: middle;
  }

  .keg-table tbody tr:nth-child(even){
    background:#fcfcfd;
  }

  .keg-table tbody tr:hover{
    background:#f9fafb;
  }

  .keg-muted{
    color:#667085;
  }

  .keg-time{
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-variant-numeric: tabular-nums;
    color:#111827;
    white-space: nowrap;
  }

  .keg-activity{
    font-weight: 600;
    color:#101828;
  }

  .keg-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    border: 1px solid transparent;
    white-space: nowrap;
  }

  /* status default */
  .keg-badge--neutral{
    background:#f2f4f7;
    color:#344054;
    border-color:#e4e7ec;
  }

  .keg-badge--success{
    background:#ecfdf3;
    color:#027a48;
    border-color:#abefc6;
  }

  .keg-badge--danger{
    background:#fef3f2;
    color:#b42318;
    border-color:#fecdca;
  }

  .keg-link{
    color:#111827;
    font-weight: 800;
    text-decoration: none;
    border-bottom: 1px dashed #cbd5e1;
    padding-bottom: 1px;
  }
  .keg-link:hover{opacity:.85;}

  .keg-empty{
    text-align:center;
    color:#667085;
    padding: 18px 16px;
  }

  .keg-footer{
    display:flex;
    justify-content: space-between;
    align-items:center;
    gap: 10px;
    padding: 12px 16px;
    background:#fff;
  }

  .keg-footer .keg-muted{
    font-size: 13px;
  }

  /* Pagination spacing */
  .keg-pagination{
    margin-top: 14px;
    padding: 0 6px 16px 6px;
  }
</style>

<div class="keg-page">
  <div class="keg-card">
    {{-- TOPBAR --}}
    <div class="keg-topbar">
      <div>
        <h1 class="keg-title">Laporan Kegiatan</h1>
        <p class="keg-subtitle">Daftar aktivitas harian dan status verifikasi supervisor.</p>
      </div>

      <div class="keg-actions">
        {{-- Search filter (client-side) --}}
        <div class="keg-search">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
            <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <input id="kegSearch" type="text" placeholder="Cari tanggal / aktivitas / status..." />
        </div>

        <a href="{{ route('mahasiswa.kegiatan.create') }}" class="keg-btn keg-btn--tambah">Tambah</a>
        <a href="{{ route('mahasiswa.kegiatan.print') }}" class="keg-btn keg-btn--cetak">Cetak</a>
      </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
      <div class="keg-alert">{{ session('success') }}</div>
    @endif

    {{-- TABLE --}}
    <div class="keg-table-wrap">
      <table class="keg-table" id="kegTable">
        <thead>
          <tr>
            <th style="width:80px;">No</th>
            <th style="width:160px;">Tanggal</th>
            <th style="width:230px;">Masuk - Pulang</th>
            <th>Aktivitas</th>
            <th style="width:220px;">Verifikasi Supervisor</th>
            <th style="width:120px;">Detail</th>
          </tr>
        </thead>

        <tbody>
          @forelse($kegiatans as $i => $k)
            @php
              $statusRaw = (string)($k->status ?? '');
              $status = strtolower(trim($statusRaw));

              // mapping badge style
              if (in_array($status, ['approved', 'disetujui', 'approve'])) {
                  $badgeClass = 'keg-badge--success';
                  $label = 'Approved';
              } elseif (in_array($status, ['rejected', 'ditolak', 'reject'])) {
                  $badgeClass = 'keg-badge--danger';
                  $label = 'Rejected';
              } else {
                  $badgeClass = 'keg-badge--neutral';
                  $label = $statusRaw !== '' ? $statusRaw : 'Pending';
              }

              $no = method_exists($kegiatans, 'firstItem') && $kegiatans->firstItem()
                    ? $kegiatans->firstItem() + $i
                    : $i + 1;

              $masuk = $k->jam_masuk ? substr($k->jam_masuk, 0, 5) : '-';
              $pulang = $k->jam_pulang ? substr($k->jam_pulang, 0, 5) : '-';
            @endphp

            <tr>
              <td class="keg-muted">{{ $no }}</td>
              <td>{{ optional($k->tanggal)->format('d-m-Y') ?? '-' }}</td>
              <td class="keg-time">{{ $masuk }} — {{ $pulang }}</td>
              <td class="keg-activity">{{ \Illuminate\Support\Str::limit($k->aktivitas, 60) }}</td>
              <td>
                <span class="keg-badge {{ $badgeClass }}">{{ $label }}</span>
              </td>
              <td>
                <a class="keg-link" href="{{ route('mahasiswa.kegiatan.show', $k->id) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="keg-empty">Belum ada laporan kegiatan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- FOOTER --}}
    <div class="keg-footer">
      <span class="keg-muted">
        Total data: {{ method_exists($kegiatans, 'total') ? $kegiatans->total() : $kegiatans->count() }}
      </span>
      <span class="keg-muted">Terakhir diperbarui: {{ now()->format('d-m-Y H:i') }}</span>
    </div>

    {{-- PAGINATION --}}
    <div class="keg-pagination">
      {{ $kegiatans->links() }}
    </div>
  </div>
</div>

<script>
  // Search filter realtime (client-side)
  (function () {
    const input = document.getElementById('kegSearch');
    const table = document.getElementById('kegTable');
    if (!input || !table) return;

    input.addEventListener('input', function () {
      const q = this.value.toLowerCase().trim();
      const rows = table.querySelectorAll('tbody tr');

      rows.forEach(row => {
        // skip row empty
        if (row.querySelector('.keg-empty')) return;

        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
      });
    });
  })();
</script>
@endsection
  