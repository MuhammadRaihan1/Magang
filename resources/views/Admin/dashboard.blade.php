@extends('Admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    /* Dashboard Admin - Profesional & mirip Supervisor */
    .hero-card{
        background:#ffffff;
        border-radius:18px;
        padding:24px 26px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:18px;
        box-shadow:0 4px 14px rgba(0,0,0,.06);
    }

    .hero-card h2{
        margin:0;
        font-size:36px;
        font-weight:900;
        color:#0f172a;
        line-height:1.15;
    }

    /* Subjudul dibuat lebih besar & jelas */
    .hero-card h5{
        margin:10px 0 0;
        color:rgba(15,23,42,.78);
        font-weight:800;
        font-size:19px;
        letter-spacing:.2px;
    }

    .hero-card img{
        height:125px;
        width:auto;
    }

    .stat-grid{
        margin-top:22px;
        display:grid;
        grid-template-columns:repeat(2, minmax(0, 1fr));
        gap:18px;
    }

    @media (max-width: 900px){
        .stat-grid{ grid-template-columns:1fr; }
        .hero-card{ flex-direction:column; align-items:flex-start; }
        .hero-card img{ height:110px; }
    }

    .stat-box{
        border-radius:18px;
        padding:22px;
        text-align:center;
        box-shadow:0 4px 14px rgba(0,0,0,.06);
        position:relative;
        min-height:170px;

        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        gap:8px;
    }

    .stat-box.dark{
        background:#6c757d;
        color:#fff;
    }

    .stat-box.light{
        background:#fff;
        border:1px solid rgba(15,23,42,.12);
        color:#0f172a;
    }

    .mini-logo{
        position:absolute;
        top:14px;
        left:14px;
        width:44px;
        height:auto;
        opacity:.95;
    }

    .stat-title{
        font-weight:900;
        font-size:18px;
        margin-top:8px;
    }

    .stat-value{
        font-size:58px;
        font-weight:900;
        line-height:1;
    }
</style>

{{-- HERO / WELCOME --}}
<div class="hero-card">
    <div>
        <h2>Selamat datang Admin</h2>
        <h5>Di Website Manajemen Magang</h5>
    </div>

    <img src="{{ asset('images/admin-3d.png') }}" alt="Admin">
</div>

{{-- STATS --}}
<div class="stat-grid">
    <div class="stat-box dark">
        <img class="mini-logo" src="{{ asset('images/logo a.png') }}" alt="Logo">
        <div class="stat-title">Total Supervisor</div>
        <div class="stat-value">{{ $totalSupervisor ?? 0 }}</div>
    </div>

    <div class="stat-box light">
        <img class="mini-logo" src="{{ asset('images/logo a.png') }}" alt="Logo">
        <div class="stat-title">Total Mahasiswa Magang</div>
        <div class="stat-value">{{ $totalMahasiswa ?? 0 }}</div>
    </div>
</div>
@endsection
