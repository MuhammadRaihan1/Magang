<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Supervisor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #eef2f7;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #bcd0f7, #9fb8f3);
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
        }

        .sidebar img {
            max-width: 150px;
        }

        .sidebar a {
            color: #1e293b;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: 0.2s ease;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: rgba(255,255,255,.4);
        }

        .sidebar small {
            font-size: 11px;
            letter-spacing: .5px;
        }

        .sidebar-content {
            flex-grow: 1;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            padding: 30px 40px;
        }

        .content-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 6px 18px rgba(0,0,0,.06);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
            }
            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="app-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="sidebar-content">

            <div class="text-center mb-4">
                <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari">
            </div>

            <a href="{{ route('supervisor.dashboard') }}"
               class="{{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <hr>

            <small class="text-muted d-block mb-2">LAYANAN</small>

            <a href="{{ route('supervisor.mahasiswa.index') }}"
               class="{{ request()->routeIs('supervisor.mahasiswa.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Mahasiswa
            </a>

            <a href="{{ route('supervisor.kegiatan.index') }}"
               class="{{ request()->routeIs('supervisor.kegiatan.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                Laporan Kegiatan
            </a>

            <a href="{{ route('supervisor.penilaian.index') }}"
               class="{{ request()->routeIs('supervisor.penilaian.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i>
                Penilaian
            </a>

        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="main-content">
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>