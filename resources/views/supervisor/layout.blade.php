<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Supervisor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color:#f8f9fa; margin:0; }

        .sidebar{
            width:260px;
            min-height:100vh;
            background-color:#bcd0f7;
            display:flex;
            flex-direction:column;
        }

        .sidebar img{ max-width:160px; }

        .sidebar a{
            color:#000;
            font-weight:600;
            text-decoration:none;
            display:block;
            padding:10px 15px;
            border-radius:8px;
            margin-bottom:5px;
        }

        .sidebar a.active,
        .sidebar a:hover{
            background-color:#a5bdf0;
        }

        .sidebar-content{ flex-grow:1; }
        .content{ padding:30px; width:100%; }
    </style>
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="sidebar p-3">

        <div class="sidebar-content">
            <div class="text-center mb-4">
                <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari">
            </div>

            <a href="{{ route('supervisor.dashboard') }}"
               class="{{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                ☰ Dashboard
            </a>

            <hr>
            <small class="text-muted px-2">LAYANAN</small>

            <a href="{{ route('supervisor.mahasiswa.index') }}"
               class="{{ request()->routeIs('supervisor.mahasiswa.*') ? 'active' : '' }}">
                📄 Mahasiswa
            </a>

            {{-- ✅ TAMBAH MENU LAPORAN KEGIATAN --}}
            <a href="{{ route('supervisor.kegiatan.index') }}"
               class="{{ request()->routeIs('supervisor.kegiatan.*') ? 'active' : '' }}">
                🧾 Laporan Kegiatan
            </a>

            {{-- ✅ Evaluasi --}}
            <a href="{{ route('supervisor.evaluasi.index') }}"
               class="{{ request()->routeIs('supervisor.evaluasi.*') ? 'active' : '' }}">
                📝 Evaluasi
            </a>
        </div>

        {{-- LOGOUT --}}
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100"
                        onclick="return confirm('Yakin ingin logout?')">
                    ⏻ Logout
                </button>
            </form>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>

</div>

</body>
</html>
