<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Mahasiswa')</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    :root{
      --sidebar:#b9c9f1;
      --content:#eef2ff;
      --text:#0f172a;
      --danger:#DB1514;
      --danger-hover:#b31212;
      --menu-hover: rgba(255,255,255,.45);
      --menu-active: rgba(255,255,255,.65);
      --section-bg: rgba(15,23,42,.18);
      --section-text: rgba(15,23,42,.75);
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
      width:250px;
      background: var(--sidebar);
      padding:14px 16px 18px;
      display:flex;
      flex-direction:column;
    }

    .dash-brand{
      display:flex;
      justify-content:center;
      margin-bottom:14px;
    }

    .dash-brand-logo{
      width:170px;
    }

    .dash-menu{
      display:flex;
      flex-direction:column;
      gap:6px;
    }

    .dash-section-title{
      margin:14px 0 6px;
      font-size:11px;
      font-weight:800;
      color: var(--section-text);
      background: var(--section-bg);
      padding:6px 10px;
      border-radius:8px;
      letter-spacing:.5px;
    }

    .dash-link{
      display:flex;
      align-items:center;
      gap:10px;
      padding:10px 12px;
      border-radius:12px;
      color: var(--text);
      text-decoration:none;
      font-weight:700;
      transition:all .2s ease;
    }

    .dash-link:hover{
      background: var(--menu-hover);
    }

    .dash-link.active{
      background: var(--menu-active);
    }

    .dash-ico{
      width:18px;
      display:flex;
      justify-content:center;
      font-size:15px;
    }

    .dash-main{
      flex:1;
      display:flex;
      flex-direction:column;
    }

    .dash-topbar{
      height:52px;
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:flex-end;
      padding:0 18px;
      border-bottom:1px solid rgba(15,23,42,.08);
      font-weight:700;
      font-size:14px;
    }

    .dash-content{
      padding:22px;
    }

    @media(max-width:992px){
      .dash-sidebar{
        width:220px;
      }
      .dash-brand-logo{
        width:150px;
      }
    }
  </style>
</head>

<body class="dash-page">
<div class="dash-wrap">

  <aside class="dash-sidebar">
    <div class="dash-brand">
      <img src="{{ asset('images/bank.png') }}" class="dash-brand-logo">
    </div>

    <div class="dash-menu">

      <a class="dash-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
         href="{{ route('mahasiswa.dashboard') }}">
        <span class="dash-ico"><i class="bi bi-speedometer2"></i></span>
        <span>Dashboard</span>
      </a>

      <div class="dash-section-title">LAYANAN</div>

      <a class="dash-link {{ request()->routeIs('mahasiswa.kegiatan.*') ? 'active' : '' }}"
         href="{{ route('mahasiswa.kegiatan.index') }}">
        <span class="dash-ico"><i class="bi bi-journal-text"></i></span>
        <span>Laporan Kegiatan</span>
      </a>

      <a class="dash-link {{ request()->routeIs('mahasiswa.penilaian.*') ? 'active' : '' }}"
         href="{{ route('mahasiswa.penilaian.index') }}">
        <span class="dash-ico"><i class="bi bi-bar-chart-line"></i></span>
        <span>Penilaian</span>
      </a>

    </div>

  </aside>

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