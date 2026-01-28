<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Supervisor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #bcd0f7;
            display: flex;
            flex-direction: column;
        }

        .sidebar img {
            max-width: 160px;
        }

        .sidebar a {
            color: #000;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #a5bdf0;
        }

        .sidebar-content {
            flex-grow: 1;
        }

        .content {
            padding: 30px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <aside class="sidebar p-3">

        <div class="sidebar-content">

            {{-- LOGO --}}
            <div class="text-center mb-4">
                <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari">
            </div>

            {{-- DASHBOARD --}}
            <a href="{{ route('supervisor.dashboard') }}"
               class="{{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <hr>
            <small class="text-muted px-2 d-block mb-2">LAYANAN</small>

            {{-- MAHASISWA --}}
            <a href="{{ route('supervisor.mahasiswa.index') }}"
               class="{{ request()->routeIs('supervisor.mahasiswa.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Mahasiswa
            </a>

            {{-- LAPORAN KEGIATAN --}}
            <a href="{{ route('supervisor.kegiatan.index') }}"
               class="{{ request()->routeIs('supervisor.kegiatan.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                Laporan Kegiatan
            </a>

            {{-- EVALUASI --}}
            <a href="{{ route('supervisor.evaluasi.index') }}"
               class="{{ request()->routeIs('supervisor.evaluasi.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                Evaluasi
            </a>

            {{-- PENILAIAN --}}
            <a href="{{ route('supervisor.penilaian.index') }}"
               class="{{ request()->routeIs('supervisor.penilaian.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i>
                Penilaian
            </a>
        </div>

        {{-- LOGOUT --}}
        <div class="mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="btn btn-danger w-100"
                        onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- CONTENT --}}
    <main class="content">
        @yield('content')
    </main>

</div>

</body>
</html>
