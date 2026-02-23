@extends('supervisor.layout')

@section('content')
<style>
  .page-wrap{
    font-family: "Times New Roman", Times, serif;
    color:#000;
  }

  .crumb{
    font-size:13px;
    margin-bottom:6px;
    color:#555;
  }

  .page-title{
    font-size:22px;
    margin:0 0 14px;
    font-weight:normal;
  }

  .hero{
    border-radius:12px;
    padding:18px;
    background: linear-gradient(90deg,#0b5ed7 0%, #1e88e5 60%, #0b5ed7 100%);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:16px;
  }

  .hero h3{
    margin:0;
    font-size:18px;
    font-weight:normal;
  }

  .hero p{
    margin:6px 0 0;
    font-size:14px;
    font-weight:normal;
  }

  .btn-soft{
    display:inline-block;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    border:1px solid #fff;
    background:#fff;
    color:#0b5ed7;
    margin-top:10px;
    margin-right:8px;
  }

  .pill{
    font-size:13px;
    padding:6px 12px;
    border-radius:999px;
    background: rgba(255,255,255,.2);
    border: 1px solid rgba(255,255,255,.3);
  }

  .cards{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:14px;
    margin-bottom:16px;
  }

  .stat{
    border-radius:12px;
    background:#fff;
    border:1px solid #ddd;
    padding:14px 16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
  }

  .stat h6{
    margin:0;
    font-size:14px;
    font-weight:normal;
  }

  .stat h2{
    margin:6px 0 0;
    font-size:22px;
    font-weight:normal;
  }

  .layout-bottom{
    display:grid;
    grid-template-columns: 1.2fr .8fr;
    gap:14px;
  }

  .panel{
    background:#fff;
    border:1px solid #ddd;
    border-radius:12px;
  }

  .panel-head{
    padding:12px 14px;
    border-bottom:1px solid #eee;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
  }

  .panel-title{
    margin:0;
    font-size:16px;
    font-weight:normal;
  }

  .panel-body{
    padding:14px;
  }

  .activity-list{
    max-height:420px;
    overflow:auto;
    padding-right:6px;
  }

  .activity-list::-webkit-scrollbar{ width:8px; }
  .activity-list::-webkit-scrollbar-track{ background:#f1f5f9; border-radius:10px; }
  .activity-list::-webkit-scrollbar-thumb{ background:#cbd5e1; border-radius:10px; }
  .activity-list::-webkit-scrollbar-thumb:hover{ background:#94a3b8; }

  .act-item{
    border:1px solid #eee;
    border-radius:10px;
    padding:12px;
    margin-bottom:10px;
  }

  .act-title{
    margin:0;
    font-size:14px;
    font-weight:normal;
  }

  .act-date{
    margin:4px 0 0;
    font-size:13px;
    color:green;
  }

  .act-desc{
    margin:8px 0 0;
    font-size:13px;
  }

  .act-meta{
    font-size:13px;
    margin-top:8px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    flex-wrap:wrap;
  }

  .btn-row{
    margin-top:10px;
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
  }

  .btn-mini{
    display:inline-block;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
    border:1px solid #ccc;
    background:#f8f8f8;
    color:#000;
  }

  /* ====== STATUS COLOR (TAMBAHAN) ====== */
  .status-text{
    font-size:12px;
    color:#000;
  }
  .status-approved{ color:#0b5ed7; font-weight:600; } /* biru */
  .status-pending{  color:#dc3545; font-weight:600; } /* merah */
  .status-rejected{ color:#dc3545; font-weight:600; } /* opsional: merah juga */
  /* ==================================== */

  .cal-wrap{
    display:flex;
    flex-direction:column;
    gap:10px;
  }

  .cal-month{
    font-size:14px;
    font-weight:normal;
  }

  .weekdays{
    display:grid;
    grid-template-columns: repeat(7, 1fr);
    gap:6px;
    font-size:13px;
  }

  .cal-grid{
    display:grid;
    grid-template-columns: repeat(7, 1fr);
    gap:6px;
  }

  .cal-cell{
    border:1px solid #ddd;
    border-radius:8px;
    min-height:55px;
    padding:6px;
    background:#fff;
    position:relative;
  }

  .cal-day{
    font-size:13px;
  }

  .cal-today{
    background:#eaf2ff;
    border-color:#9ec5fe;
  }

  .pending-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:orange;
    display:inline-block;
    position:absolute;
    bottom:6px;
    left:6px;
  }

  .legend{
    font-size:13px;
    margin-top:6px;
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
  }

  .legend-item{
    display:flex;
    align-items:center;
    gap:6px;
  }

  .legend-today{
    width:10px;
    height:10px;
    border-radius:50%;
    background:#60a5fa;
    display:inline-block;
  }

  .legend-pending{
    width:10px;
    height:10px;
    border-radius:50%;
    background:orange;
    display:inline-block;
  }

  @media (max-width: 992px){
    .cards{ grid-template-columns: 1fr; }
    .layout-bottom{ grid-template-columns: 1fr; }
  }
</style>

<div class="page-wrap">
  <div class="crumb">Application / Dashboard</div>
  <h2 class="page-title">Dashboard</h2>

  <div class="hero">
    <div>
      <h3>Selamat datang, {{ auth()->user()->name }}</h3>
      <p>Ringkasan verifikasi laporan mahasiswa bimbingan</p>
      <a class="btn-soft" href="{{ route('supervisor.kegiatan.index', ['status' => 'Pending']) }}">Verifikasi Laporan</a>
      <a class="btn-soft" href="{{ route('supervisor.penilaian.index') }}">Beri Penilaian</a>
    </div>
    <div class="pill">Supervisor</div>
  </div>

  <div class="cards">
    <div class="stat">
      <div>
        <h6>Total Mahasiswa Bimbingan</h6>
        <h2>{{ $totalMahasiswa ?? 0 }}</h2>
      </div>
      <a class="btn-mini" href="{{ route('supervisor.mahasiswa.index') }}">Lihat</a>
    </div>

    <div class="stat">
      <div>
        <h6>Laporan Belum Diverifikasi</h6>
        <h2>{{ $pendingKegiatan ?? 0 }}</h2>
      </div>
      <a class="btn-mini" href="{{ route('supervisor.kegiatan.index', ['status' => 'Pending']) }}">Cek</a>
    </div>
  </div>

  <div class="layout-bottom">
    <div class="panel">
      <div class="panel-head">
        <h4 class="panel-title">Aktivitas Terbaru</h4>
        <a class="btn-mini" href="{{ route('supervisor.kegiatan.index') }}">Lihat Semua</a>
      </div>
      <div class="panel-body">
        <div class="activity-list">
          @if(!empty($recentKegiatan) && $recentKegiatan->count() > 0)
            @foreach($recentKegiatan as $item)
              @php
                $st = strtolower($item->status ?? 'pending');
                $statusLabel = $st === 'approved' ? 'Approved' : ($st === 'rejected' ? 'Rejected' : 'Pending');
              @endphp

              <div class="act-item">
                <p class="act-title">Laporan Kegiatan</p>

                <p class="act-date">
                  @if(!empty($item->tanggal))
                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                  @elseif(!empty($item->created_at))
                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                  @else
                    {{ '' }}
                  @endif
                </p>

                @php
                  $desc = $item->kegiatan ?? $item->deskripsi ?? $item->judul ?? '';
                @endphp
                @if(!empty($desc))
                  <p class="act-desc">{{ $desc }}</p>
                @endif

                <div class="act-meta">
                  <div>Mahasiswa: {{ $item->mahasiswa->name ?? '' }}</div>
                </div>

                <div class="btn-row">
                  <a class="btn-mini" href="{{ route('supervisor.kegiatan.show', $item->id) }}">Detail</a>

                  {{-- STATUS: Approved biru, Pending merah --}}
                  <span class="status-text {{ $st === 'approved' ? 'status-approved' : ($st === 'rejected' ? 'status-rejected' : 'status-pending') }}">
                    {{ $statusLabel }}
                  </span>
                </div>
              </div>
            @endforeach
          @else
            <div class="act-item" style="margin-bottom:0;">
              <p class="act-title">Belum ada aktivitas</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="panel">
  <div class="panel-head">
    <h4 class="panel-title">Jadwal Pribadi</h4>
  </div>
  <div class="panel-body">
    <div class="cal-wrap">

      <div style="display:flex;justify-content:space-between;align-items:center;">
        <a class="btn-mini" href="?month={{ $prevMonth }}&year={{ $prevYear }}">←</a>
        <div class="cal-month">{{ $monthName }} {{ $year }}</div>
        <a class="btn-mini" href="?month={{ $nextMonth }}&year={{ $nextYear }}">→</a>
      </div>

      <div class="weekdays">
        <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div>
        <div>Jum</div><div>Sab</div><div>Min</div>
      </div>

      <div class="cal-grid">
        @for($i=0; $i<$startOffset; $i++)
          <div class="cal-cell" style="border:none;background:transparent;"></div>
        @endfor

        @for($d=1; $d<=$daysInMonth; $d++)
          @php
            $isToday = ($todayDay === $d);
            $hasPending = !empty($pendingDays[$d]);
          @endphp

          <div class="cal-cell {{ $isToday ? 'cal-today' : '' }}">
            <div class="cal-day">{{ $d }}</div>
            @if($hasPending)
              <span class="pending-dot"></span>
            @endif
          </div>
        @endfor
      </div>
      
          <div class="legend">
            <div class="legend-item">
              <span class="legend-today"></span>
              <span>Hari Ini</span>
            </div>
            <div class="legend-item">
              <span class="legend-pending"></span>
              <span>Ada laporan pending</span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection