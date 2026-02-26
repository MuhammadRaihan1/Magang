@extends('admin.layout')

@section('content')
<style>
  .page-wrap{
    font-family:"Times New Roman", Times, serif;
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
    cursor:pointer;
  }

  .admin-wrapper{
    position:relative;
  }

  .admin-menu{
    display:none;
    position:absolute;
    right:0;
    top:40px;
    background:#fff;
    border-radius:8px;
    min-width:120px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
    overflow:hidden;
    z-index:999;
  }

  .admin-menu a{
    display:block;
    padding:8px 12px;
    text-decoration:none;
    font-size:13px;
    color:#000;
  }

  .admin-menu a:hover{
    background:#f5f5f5;
  }

  .admin-wrapper.active .admin-menu{
    display:block;
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

  .btn-mini{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
    border:1px solid #ccc;
    background:#f8f8f8;
    color:#000;
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
    justify-content:space-between;
    align-items:center;
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

  .act-meta{
    font-size:13px;
    margin-top:8px;
  }

  .cal-wrap{
    display:flex;
    flex-direction:column;
    gap:10px;
  }

  .cal-month-nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
  }

  .cal-nav-btn{
    text-decoration:none;
    font-size:13px;
    padding:4px 8px;
    border:1px solid #ccc;
    border-radius:6px;
    color:#000;
    background:#f8f8f8;
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

  .created-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:orange;
    position:absolute;
    bottom:6px;
    left:6px;
  }

  .legend{
    font-size:13px;
    margin-top:6px;
    display:flex;
    gap:12px;
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
  }

  .legend-created{
    width:10px;
    height:10px;
    border-radius:50%;
    background:orange;
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
      <p>Ringkasan pengelolaan akun mahasiswa dan supervisor</p>
      <a class="btn-soft" href="{{ route('admin.mahasiswa.create') }}">Tambah Mahasiswa</a>
      <a class="btn-soft" href="{{ route('admin.supervisor.create') }}">Tambah Supervisor</a>
    </div>

    <div class="admin-wrapper" id="adminDropdown">
      <div class="pill" onclick="toggleAdmin()">Admin ▾</div>
      <div class="admin-menu">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      </div>
    </div>
  </div>

  <div class="cards">
    <div class="stat">
      <div>
        <h6>Total Supervisor</h6>
        <h2>{{ $totalSupervisor ?? 0 }}</h2>
      </div>
      <a class="btn-mini" href="{{ route('admin.supervisor.index') }}">Lihat</a>
    </div>

    <div class="stat">
      <div>
        <h6>Total Mahasiswa</h6>
        <h2>{{ $totalMahasiswa ?? 0 }}</h2>
      </div>
      <a class="btn-mini" href="{{ route('admin.mahasiswa.index') }}">Lihat</a>
    </div>
  </div>

  <div class="layout-bottom">
    <div class="panel">
      <div class="panel-head">
        <h4 class="panel-title">Aktivitas Terbaru</h4>
      </div>
      <div class="panel-body">
        <div class="activity-list">
          @forelse($recentUsers as $u)
            <div class="act-item">
              <p class="act-title">{{ $u->name }}</p>
              <p class="act-date">
                {{ \Carbon\Carbon::parse($u->created_at)->timezone('Asia/Jakarta')->translatedFormat('l, d F Y - H:i') }}
              </p>
              <div class="act-meta">
                Email: {{ $u->email }} | {{ ucfirst($u->role) }}
              </div>
            </div>
          @empty
            <div class="act-item">
              <p class="act-title">Belum ada aktivitas</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h4 class="panel-title">Jadwal Akun Dibuat</h4>
      </div>
      <div class="panel-body">
        <div class="cal-wrap">
          <div class="cal-month-nav">
            <a class="cal-nav-btn" href="?month={{ $prevMonth }}&year={{ $prevYear }}">←</a>
            <div>{{ $monthName }} {{ $year }}</div>
            <a class="cal-nav-btn" href="?month={{ $nextMonth }}&year={{ $nextYear }}">→</a>
          </div>

          <div class="weekdays">
            <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div><div>Min</div>
          </div>

          <div class="cal-grid">
            @for($i=0; $i<$startOffset; $i++)
              <div></div>
            @endfor

            @for($d=1; $d<=$daysInMonth; $d++)
              @php
                $isToday = ($todayDay === $d);
                $hasCreated = !empty($createdDays[$d]);
              @endphp

              <div class="cal-cell {{ $isToday ? 'cal-today' : '' }}">
                <div class="cal-day">{{ $d }}</div>
                @if($hasCreated)
                  <span class="created-dot"></span>
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
              <span class="legend-created"></span>
              <span>Ada akun dibuat</span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleAdmin(){
  document.getElementById('adminDropdown').classList.toggle('active');
}

document.addEventListener('click', function(e){
  var dropdown = document.getElementById('adminDropdown');
  if(!dropdown.contains(e.target)){
    dropdown.classList.remove('active');
  }
});
</script>

@endsection