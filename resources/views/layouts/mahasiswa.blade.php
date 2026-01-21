<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Mahasiswa')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root{
      --sidebar:#b9c9f1;
      --content:#eef2ff;
      --text:#0f172a;

      --danger:#DB1514;
      --danger-hover:#b31212;
      --menu-hover: rgba(255,255,255,.45);
      --menu-active: rgba(255,255,255,.6);
      --section-bg: rgba(15,23,42,.25);
      --section-text: rgba(15,23,42,.65);
    }

    *{ box-sizing:border-box; }

    body.dash-page{
      margin:0;
      font-family: Arial, sans-serif;
      background: var(--content);
      color: var(--text);
    }

    .dash-wrap{
      display:flex;
      min-height:100vh;
    }

    .dash-sidebar{
      width:260px;
      background: var(--sidebar);
      padding:18px;
      display:flex;
      flex-direction:column;
    }

    .dash-brand{
      display:flex;
      justify-content:center;
      align-items:center;
      margin-bottom:22px;
    }

    .dash-brand-logo{
      width:190px;
      height:auto;
    }

    .dash-menu{
      display:flex;
      flex-direction:column;
    }

    .dash-section-title{
      margin:18px 0 10px;
      font-size:12px;
      font-weight:800;
      color: var(--section-text);
      background: var(--section-bg);
      padding:8px 12px;
      border-radius:10px;
    }

    .dash-link{
      display:flex;
      align-items:center;
      gap:10px;
      padding:12px 14px;
      border-radius:14px;
      color: var(--text);
      text-decoration:none;
      margin-bottom:10px;
      font-weight:700;
    }

    .dash-link:hover{ background: var(--menu-hover); }
    .dash-link.active{ background: var(--menu-active); }

    .dash-ico{
      width:18px;
      display:inline-flex;
      justify-content:center;
    }

    .dash-sidebar-footer{
      margin-top:auto;
      padding-top:14px;
    }

    .btn-logout{
      width:100%;
      height:46px;
      border:none;
      border-radius:14px;
      background: var(--danger);
      color:#fff;
      font-weight:800;
      cursor:pointer;

      display:flex;
      align-items:center;
      justify-content:center;
      gap:10px;

      appearance:none;
      -webkit-appearance:none;
    }

    .btn-logout:hover{
      background: var(--danger-hover);
    }

    .dash-main{
      flex:1;
      display:flex;
      flex-direction:column;
      min-width:0;
    }

    .dash-topbar{
      height:58px;
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:0 22px;
      border-bottom:1px solid rgba(15,23,42,.08);
    }

    .dash-topbar-name{
      font-weight:800;
    }

    .dash-content{
      padding:26px;
    }
  </style>
</head>

<body class="dash-page">
  <div class="dash-wrap">

    <aside class="dash-sidebar">
      <div class="dash-brand">
        <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari" class="dash-brand-logo">
      </div>

      <div class="dash-menu">
        <a class="dash-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
           href="{{ route('mahasiswa.dashboard') }}">
          <span class="dash-ico">☰</span>
          <span>Dashboard</span>
        </a>

        <div class="dash-section-title">LAYANAN</div>

        <a class="dash-link {{ request()->routeIs('mahasiswa.kegiatan.*') ? 'active' : '' }}"
           href="{{ route('mahasiswa.kegiatan.index') }}">
          <span class="dash-ico">🗒️</span>
          <span>Laporan Kegiatan</span>
        </a>

        <a class="dash-link {{ request()->routeIs('mahasiswa.evaluasi.*') ? 'active' : '' }}"
           href="{{ route('mahasiswa.evaluasi.index') }}">
          <span class="dash-ico">📝</span>
          <span>Evaluasi</span>
        </a>
      </div>

      <div class="dash-sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-logout">
            <span>🚪</span>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    <main class="dash-main">
      <div class="dash-topbar">
        <div></div>
        <div class="dash-topbar-name">{{ auth()->user()->name ?? 'Nama' }}</div>
      </div>

      <div class="dash-content">
        @yield('content')
      </div>
    </main>

  </div>
</body>
</html>
  