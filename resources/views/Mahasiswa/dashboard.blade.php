@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<style>
.page-wrap{
  padding:20px;
  background:#f5f7fa;
  min-height:calc(100vh - 80px);
  font-size:14px;
}

.page-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:16px;
}

.page-header .breadcrumb{
  font-size:13px;
  opacity:.6;
}

.page-header h2{
  font-size:18px;
  margin:4px 0 0;
  font-weight:500;
}

.welcome{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:16px 18px;
  border-radius:14px;
  background:linear-gradient(90deg,#0ea5e9,#2563eb);
  color:#fff;
  position:relative;
}

.welcome h3{ margin:0; font-size:16px; font-weight:500; }
.welcome p{ margin:4px 0 0; font-size:13px; opacity:.9; }

.user-dropdown{ position:relative; cursor:pointer; }

.dropdown-menu{
  position:absolute;
  right:0;
  top:40px;
  background:#fff;
  color:#111;
  border-radius:10px;
  box-shadow:0 8px 20px rgba(0,0,0,.1);
  padding:8px 0;
  min-width:140px;
  display:none;
  z-index:100;
}

.dropdown-menu button{
  display:block;
  width:100%;
  padding:8px 14px;
  font-size:13px;
  text-align:left;
  background:none;
  border:none;
  cursor:pointer;
  color:#ef4444;
}

.dropdown-menu button:hover{ background:#f1f5f9; }

.show-dropdown{ display:block; }

.grid{ display:grid; gap:16px; }

.grid-2{
  display:grid;
  grid-template-columns:1.2fr .8fr;
  gap:16px;
}

@media(max-width:992px){
  .grid-2{grid-template-columns:1fr;}
}

.card{
  background:#fff;
  border-radius:14px;
  padding:16px;
  box-shadow:0 4px 14px rgba(0,0,0,.05);
}

.card-title{ font-size:14px; margin-bottom:12px; }

.step-row{
  display:flex;
  gap:12px;
  margin-bottom:14px;
  align-items:flex-start;
}

.step-badge{
  width:28px;
  height:28px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#e2e8f0;
  font-size:12px;
}

.step-active{ background:#0ea5e9; color:#fff; }

.step-title{ font-size:13px; }

.step-desc{ font-size:12px; opacity:.7; }

.activity-wrapper{
  max-height:350px;
  overflow-y:auto;
  padding-right:6px;
}

.activity-item{
  padding:12px;
  border:1px solid #edf2f7;
  border-radius:10px;
  margin-bottom:10px;
  transition:.2s;
}

.activity-item:hover{
  transform:translateY(-3px);
  box-shadow:0 6px 18px rgba(0,0,0,.08);
}

.a-title{font-size:13px;}
.a-time{font-size:12px;color:#16a34a;margin:3px 0;}
.a-desc{font-size:12px;opacity:.8;}

.cal-header{ display:flex; justify-content:space-between; margin-bottom:10px; }

.cal-grid{
  display:grid;
  grid-template-columns:repeat(7,1fr);
  gap:6px;
}

.cal-cell{
  border:1px solid #edf2f7;
  border-radius:8px;
  min-height:70px;
  padding:6px;
  font-size:12px;
  display:flex;
  flex-direction:column;
  gap:4px;
}

.cal-date{ font-size:12px; }

.cal-status{
  font-size:10px;
  padding:2px 6px;
  border-radius:999px;
  width:fit-content;
}

.status-pending{background:#e2e8f0;color:#334155;}
.status-approved{background:#bbf7d0;color:#065f46;}
.status-rejected{background:#fecaca;color:#7f1d1d;}

.cal-today{ background:#e0f2fe; border-color:#7dd3fc; }

.legend{
  display:flex;
  gap:14px;
  margin-top:12px;
  font-size:12px;
}

.legend-item{
  display:flex;
  align-items:center;
  gap:6px;
}

.dot{ width:10px; height:10px; border-radius:50%; }
.dot-today{background:#38bdf8;}
.dot-pending{background:#94a3b8;}
.dot-approved{background:#22c55e;}
.dot-rejected{background:#ef4444;}
</style>

@php
$activities = $lastActivities ?? collect();

$step1Active = false;
$step2Active = false;
$step3Active = false;

$step1Text = 'Belum membuat laporan hari ini';
$step2Text = 'Belum ada laporan untuk diverifikasi';
$step3Text = 'Nilai akhir belum diberikan';

if(isset($laporanHariIni) && $laporanHariIni){
    $step1Active = true;
    $step1Text = 'Laporan hari ini sudah dibuat';

    $status = method_exists($laporanHariIni,'getVerifikasiStatus')
        ? $laporanHariIni->getVerifikasiStatus()
        : ($laporanHariIni->status ?? 'pending');

    if($status === 'approved'){
        $step2Active = true;
        $step2Text = 'Laporan hari ini sudah diverifikasi';
    } elseif($status === 'rejected'){
        $step2Text = 'Laporan hari ini ditolak supervisor';
    } else {
        $step2Text = 'Menunggu verifikasi supervisor';
    }
}

if(isset($penilaian) && $penilaian && $penilaian->nilai_akhir){
    $step3Active = true;
    $step3Text = 'Nilai akhir sudah diberikan';
}
@endphp

<div class="page-wrap">

  <div class="page-header">
    <div>
      <div class="breadcrumb">Application / Dashboard</div>
      <h2>Dashboard</h2>
    </div>
  </div>

  <div class="grid">

    <div class="welcome">
      <div>
        <h3>Selamat datang, {{ auth()->user()->name }}</h3>
        <p>Ringkasan laporan dan penilaian</p>
      </div>

      <div class="user-dropdown" onclick="toggleDropdown()">
        <span>Mahasiswa ▾</span>
        <div id="userMenu" class="dropdown-menu">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
          </form>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-title">Proses Penyelesaian Magang</div>

      <div class="step-row">
        <div class="step-badge {{ $step1Active ? 'step-active' : '' }}">1</div>
        <div>
          <div class="step-title">Laporan</div>
          <div class="step-desc">{{ $step1Text }}</div>
        </div>
      </div>

      <div class="step-row">
        <div class="step-badge {{ $step2Active ? 'step-active' : '' }}">2</div>
        <div>
          <div class="step-title">Verifikasi Laporan</div>
          <div class="step-desc">{{ $step2Text }}</div>
        </div>
      </div>

      <div class="step-row">
        <div class="step-badge {{ $step3Active ? 'step-active' : '' }}">3</div>
        <div>
          <div class="step-title">Nilai Akhir</div>
          <div class="step-desc">{{ $step3Text }}</div>
        </div>
      </div>
    </div>

    <div class="grid-2">

      <div class="card">
        <div class="card-title">Aktivitas Terbaru</div>

        <div class="activity-wrapper">
        @forelse($activities as $a)

          @php
            $status = method_exists($a,'getVerifikasiStatus')
                ? $a->getVerifikasiStatus()
                : ($a->status ?? 'pending');
          @endphp

          <div class="activity-item">

            @if($status === 'approved')
              <div class="a-title">Laporan sudah diverifikasi supervisor</div>
            @elseif($status === 'rejected')
              <div class="a-title">Laporan ditolak supervisor</div>
            @else
              <div class="a-title">Laporan dikirim dan menunggu verifikasi</div>
            @endif

            <div class="a-time">
              {{ \Carbon\Carbon::parse($a->updated_at)->translatedFormat('d F Y - H:i') }}
            </div>

            <div class="a-desc">
              {{ $a->aktivitas }}
            </div>

          </div>

        @empty
          <div class="activity-item">Belum ada laporan</div>
        @endforelse
        </div>
      </div>

      <div class="card">
        <div class="card-title">Jadwal Pribadi</div>

        <div class="cal-header">
          <a href="?month={{ $prevMonth }}&year={{ $prevYear }}">←</a>
          <div>{{ $monthName }} {{ $year }}</div>
          <a href="?month={{ $nextMonth }}&year={{ $nextYear }}">→</a>
        </div>

        <div class="cal-grid">
          @for($i=0;$i<$startOffset;$i++)
            <div></div>
          @endfor

          @for($i=1;$i<=$daysInMonth;$i++)
            @php $st = $statusByDate[$i] ?? null; @endphp
            <div class="cal-cell {{ $todayDay === $i ? 'cal-today' : '' }}">
              <div class="cal-date">{{ $i }}</div>
              @if($st)
                <div class="cal-status
                  @if($st=='approved') status-approved
                  @elseif($st=='rejected') status-rejected
                  @else status-pending
                  @endif">
                  {{ ucfirst($st) }}
                </div>
              @endif
            </div>
          @endfor
        </div>

        <div class="legend">
          <div class="legend-item"><div class="dot dot-today"></div> Hari Ini</div>
          <div class="legend-item"><div class="dot dot-pending"></div> Pending</div>
          <div class="legend-item"><div class="dot dot-approved"></div> Approved</div>
          <div class="legend-item"><div class="dot dot-rejected"></div> Rejected</div>
        </div>

      </div>

    </div>

  </div>

</div>

<script>
function toggleDropdown() {
    document.getElementById("userMenu").classList.toggle("show-dropdown");
}

window.onclick = function(e) {
    if (!e.target.closest('.user-dropdown')) {
        var dropdown = document.getElementById("userMenu");
        if (dropdown.classList.contains('show-dropdown')) {
            dropdown.classList.remove('show-dropdown');
        }
    }
}
</script>

@endsection