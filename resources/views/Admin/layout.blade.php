<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>

    <style>
        :root{
            --sidebar:#b9c9f1;
            --content:#eef2ff;
            --text:#0f172a;

            --primary:#50abe4;
            --danger:#DB1514;
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            font-family: Arial, sans-serif;
            background: var(--content);
            color: var(--text);
        }

        .wrap{
            display:flex;
            min-height:100vh;
        }

        .sidebar{
            width:260px;
            background: var(--sidebar);
            padding:18px;
            display:flex;
            flex-direction:column;
        }

        .sidebar-top{ flex:1; }

        .brand{
            display:flex;
            justify-content:center;
            align-items:center;
            margin-bottom:22px;
        }

        .brand img{
            width:190px;
            height:auto;
        }

        .section{
            margin:18px 0 10px;
            font-size:12px;
            font-weight:800;
            letter-spacing:.5px;
            color: rgba(15,23,42,.65);
            background: rgba(15,23,42,.25);
            padding:8px 12px;
            border-radius:10px;
        }

        .menu{
            display:flex;
            align-items:center;
            gap:10px;
            padding:12px 14px;
            border-radius:14px;
            color: var(--text);
            text-decoration:none;
            margin-bottom:10px;
            font-weight:700;
            border:none;
            background:transparent;
            cursor:pointer;
            width:100%;
        }

        .menu:hover{ background: rgba(255,255,255,.45); }
        .active{ background: rgba(255,255,255,.6); }

        .sidebar-bottom{
            margin-top:auto;
            padding-top:10px;
        }

        .content{
            flex:1;
            padding:26px;
        }

        .btn{
            height:44px;
            min-width:120px;
            padding:0 18px;
            border-radius:12px;
            background: var(--primary);
            color:#fff;
            text-decoration:none;
            font-weight:700;
            font-size:14px;
            line-height:1;
            border:none;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            appearance:none;
            -webkit-appearance:none;
        }

        .btn:hover{ opacity:.92; }

        .btn-secondary{
            background: var(--danger);
        }

        .alert{
            padding:10px 12px;
            border-radius:10px;
            background:#e8fff1;
            color:#0b6b2d;
            margin-bottom:12px;
            font-weight:700;
        }

        .error{
            padding:10px 12px;
            border-radius:10px;
            background:#ffe8e8;
            color:#8a0b0b;
            margin-bottom:12px;
            font-weight:700;
        }

        .table-card{
            background:#fff;
            border-radius:14px;
            padding:10px;
        }

        table.table-admin{
            width:100%;
            border-collapse:collapse;
            table-layout:fixed;
        }

        table.table-admin th,
        table.table-admin td{
            padding:12px;
            border-bottom:1px solid #eee;
            vertical-align:middle;
            white-space:nowrap;
        }

        table.table-admin th{
            background:#fafafa;
            font-weight:800;
        }

        table.table-admin th:nth-child(1),
        table.table-admin td:nth-child(1){
            width:60px;
            text-align:center !important;
        }

        table.table-admin th:nth-child(2),
        table.table-admin td:nth-child(2){
            width:30%;
            text-align:left !important;
        }

        table.table-admin th:nth-child(3),
        table.table-admin td:nth-child(3){
            width:40%;
            text-align:left !important;
        }

        table.table-admin th:nth-child(4),
        table.table-admin td:nth-child(4){
            width:220px;
            text-align:center !important;
        }

        .actions-center{
            display:flex;
            justify-content:center;
            gap:14px;
            align-items:center;
        }

        .btn-pill{
            padding:8px 22px;
            border-radius:999px;
            font-weight:800;
            font-size:14px;
            background:transparent;
            border:2px solid;
            cursor:pointer;
            min-width:86px;
            text-align:center;
        }

        .btn-edit-outline{ color:#16a34a; border-color:#16a34a; }
        .btn-delete-outline{ color:#ef4444; border-color:#ef4444; }

        .btn-edit-outline:hover{ background:rgba(22,163,74,.08); }
        .btn-delete-outline:hover{ background:rgba(239,68,68,.08); }

        .form-card{
            background:#fff;
            border-radius:18px;
            padding:18px;
            max-width:620px;
            box-shadow: 0 6px 18px rgba(0,0,0,.04);
        }

        .form-title{
            margin:0 0 14px;
            font-size:22px;
            font-weight:900;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:12px;
        }

        .field label{
            display:block;
            margin-bottom:6px;
            font-weight:800;
        }

        .input{
            width:100%;
            padding:12px 14px;
            border-radius:12px;
            border:1px solid #e2e8f0;
            outline:none;
            font-size:14px;
            background:#fff;
        }

        .input:focus{
            border-color:#94a3b8;
            box-shadow:0 0 0 3px rgba(148,163,184,.25);
        }

        .form-actions{
            display:flex;
            gap:12px;
            margin-top:14px;
            flex-wrap:wrap;
        }
    </style>
</head>

<body>
<div class="wrap">
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="brand">
                <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari">
            </div>

            <a class="menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">☰ Dashboard</a>

            <div class="section">LAYANAN</div>

            <a class="menu {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}"
               href="{{ route('admin.mahasiswa.index') }}">📄 Mahasiswa</a>

            <a class="menu {{ request()->routeIs('admin.supervisor.*') ? 'active' : '' }}"
               href="{{ route('admin.supervisor.index') }}">📄 Supervisor</a>
        </div>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</div>
</body>
</html>