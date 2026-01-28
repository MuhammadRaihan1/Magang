<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Mahasiswa')</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
      margin-bottom:22px;
    }

    .dash-brand-logo{
      width:190px;
    }

    .dash-menu{ display:flex; flex-direction:column; }

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
      gap:12px;
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
      width:20px;
      display:flex;
      justify-content:center;
      font-size:16px;
    }

    .dash-sidebar-footer{
      margin-top:auto;
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
    }

    .btn-logout:hover{ background: var(--danger-hover); }

    .dash-main{
      flex:1;
      display:flex;
      flex-direction:column;
    }

    .dash-topbar{
      height:58px;
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:flex-end;
      padding:0 22px;
      border-bottom:1px solid rgba(15,23,42,.08);
      font-weight:800;
    }

    .dash-content{
      padding:26px;
    }
  </style>
</head>

<body class="dash-page">
<div class="dash-wrap">

  {{-- SIDEBAR --}}
  <aside class="dash-sidebar">
    <div class="dash-brand">
      <img src="{{ asset('images/bank.png') }}" class="dash-brand-logo">
    </div>

    <div class="dash-menu">
      {{-- Dashboard --}}
      <a class="dash-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
         href="{{ route('mahasiswa.dashboard') }}">
        <span class="dash-ico"><i class="bi bi-speedometer2"></i></span>
        <span>Dashboard</span>
      </a>

      <div class="dash-section-title">LAYANAN</div>

      {{-- Laporan Kegiatan --}}
      <a class="dash-link {{ request()->routeIs('mahasiswa.kegiatan.*') ? 'active' : '' }}"
         href="{{ route('mahasiswa.kegiatan.index') }}">
        <span class="dash-ico"><i class="bi bi-journal-text"></i></span>
        <span>Laporan Kegiatan</span>
      </a>

      {{-- Evaluasi --}}
      <a class="dash-link {{ request()->routeIs('mahasiswa.evaluasi.*') ? 'active' : '' }}"
         href="{{ route('mahasiswa.evaluasi.index') }}">
        <span class="dash-ico"><i class="bi bi-clipboard-check"></i></span>
        <span>Evaluasi</span>
      </a>

      {{-- Penilaian --}}
      <a class="dash-link {{ request()->routeIs('mahasiswa.penilaian.*') ? 'active' : '' }}"
         href="{{ route('mahasiswa.penilaian.index') }}">
        <span class="dash-ico"><i class="bi bi-bar-chart-line"></i></span>
        <span>Penilaian</span>
      </a>
    </div>

    {{-- Logout --}}
    <div class="dash-sidebar-footer">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn-logout">
          <i class="bi bi-box-arrow-right"></i>
          Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- CONTENT --}}
  <main class="dash-main">
    <div class="dash-topbar">
      {{ auth()->user()->name }}
    </div>

    <div class="dash-content">
      @yield('content')
    </div>
  </main>

</div>
</body>
</html>
