@extends('Admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<style>
  /* =====================
     DASHBOARD ADMIN
     ===================== */

  .admin-wrapper{
    width:100%;
    padding:10px 0 30px;
  }

  /* HERO */
  .hero-card{
    width:100%;
    border-radius:22px;
    padding:3rem 3.5rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:24px;
    background: linear-gradient(
      135deg,
      #2563eb,
      #9333ea,
      #dc2626,
      #0d9488
    );
    background-size:300% 300%;
    animation: gradientMove 14s ease infinite;
    color:#fff;
    box-shadow:0 24px 50px rgba(0,0,0,.18);
  }

  .hero-text h2{
    margin:0;
    font-size:42px;
    font-weight:900;
    line-height:1.15;
  }

  .hero-text h5{
    margin-top:12px;
    font-size:20px;
    font-weight:600;
    opacity:.95;
  }

  .hero-card img{
    height:150px;
  }

  /* GRID */
  .stat-grid{
    margin-top:26px;
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:22px;
  }

  /* CARD STAT */
  .stat-link{
    display:block;
    text-decoration:none;
    color:inherit;
  }

  .stat-box{
    border-radius:22px;
    padding:28px;
    min-height:190px;
    position:relative;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    gap:10px;
    cursor:pointer;
    transition:.18s ease;
    box-shadow:0 10px 28px rgba(16,24,40,.12);
  }

  .stat-box:hover{
    transform: translateY(-4px);
    box-shadow:0 18px 40px rgba(16,24,40,.18);
  }

  .stat-box.dark{
    background: linear-gradient(135deg,#475569,#64748b);
    color:#fff;
  }

  .stat-box.light{
    background:#ffffff;
    border:1px solid rgba(15,23,42,.12);
    color:#0f172a;
  }

  .mini-logo{
    position:absolute;
    top:18px;
    left:18px;
    width:56px;
    opacity:.95;
  }

  .stat-title{
    font-size:20px;
    font-weight:900;
  }

  .stat-value{
    font-size:64px;
    font-weight:900;
    line-height:1;
  }

  /* ANIMASI */
  @keyframes gradientMove{
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
  }

  /* RESPONSIVE */
  @media(max-width:900px){
    .hero-card{
      flex-direction:column;
      text-align:center;
      padding:2.5rem 2rem;
    }

    .hero-card img{
      height:120px;
    }

    .stat-grid{
      grid-template-columns:1fr;
    }
  }
</style>

<div class="admin-wrapper">

  {{-- HERO --}}
  <div class="hero-card">
    <div class="hero-text">
      <h2>Selamat datang Admin</h2>
      <h5>Di Website Manajemen Magang</h5>
    </div>

    <img src="{{ asset('images/admin-3d.png') }}" alt="Admin">
  </div>

  {{-- STAT --}}
  <div class="stat-grid">

    <a href="{{ route('admin.supervisor.index') }}" class="stat-link">
      <div class="stat-box dark">
        <img class="mini-logo" src="{{ asset('images/logo a.png') }}">
        <div class="stat-title">Total Supervisor</div>
        <div class="stat-value">{{ $totalSupervisor ?? 0 }}</div>
      </div>
    </a>

    <a href="{{ route('admin.mahasiswa.index') }}" class="stat-link">
      <div class="stat-box light">
        <img class="mini-logo" src="{{ asset('images/logo a.png') }}">
        <div class="stat-title">Total Mahasiswa Magang</div>
        <div class="stat-value">{{ $totalMahasiswa ?? 0 }}</div>
      </div>
    </a>

  </div>

</div>
@endsection
  