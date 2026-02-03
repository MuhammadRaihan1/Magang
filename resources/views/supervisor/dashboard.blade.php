@extends('supervisor.layout')

@section('content')
<style>
  .stat-link{
    display:block;
    text-decoration:none;
    color:inherit;
  }

  .stat-card{
    border-radius: 18px;
    padding: 1.75rem 2rem;
    cursor:pointer;
    transition:.15s ease;
    height:100%;
  }

  .stat-card:hover{
    transform: translateY(-3px);
    box-shadow: 0 16px 30px rgba(0,0,0,.15);
  }

  .stat-inner{
    display:flex;
    align-items:center;
    gap:18px;
  }

  .stat-icon{
    width:64px;
    height:64px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:14px;
    background: rgba(255,255,255,.25);
    flex-shrink:0;
  }

  .stat-icon img{
    width:38px;
  }

  .stat-text h6{
    margin:0;
    font-size:14px;
    font-weight:600;
    opacity:.9;
  }

  .stat-text h1{
    margin:4px 0 0;
    font-size:36px;
    font-weight:800;
  }

  .stat-dark{
    background: linear-gradient(135deg,#334155,#64748b);
    color:#fff;
  }

  .stat-white{
    background: linear-gradient(135deg,#e0f2fe,#f8fafc);
    color:#0f172a;
  }

  /* HEADER WARNA ACAK */
  .dashboard-header{
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    color:#fff;
    background: linear-gradient(
      135deg,
      #2563eb,
      #dc2626,
      #9333ea,
      #0d9488
    );
    background-size: 300% 300%;
    animation: gradientMove 10s ease infinite;
  }

  @keyframes gradientMove{
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
  }
</style>

<div class="dashboard-header d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold mb-1">
      Selamat datang Supervisor {{ auth()->user()->name }}
    </h2>
    <h5 class="mb-0" style="opacity:.9;">
      Di Website Manajemen Magang
    </h5>
  </div>
  <img src="{{ asset('images/admin-3d.png') }}" style="height:120px;">
</div>

<div class="row g-4">
  <div class="col-md-6">
    <a href="{{ route('supervisor.mahasiswa.index') }}" class="stat-link">
      <div class="stat-card stat-dark">
        <div class="stat-inner">
          <div class="stat-icon">
            <img src="{{ asset('images/logo a.png') }}">
          </div>
          <div class="stat-text">
            <h6>Total Mahasiswa Bimbingan</h6>
            <h1>{{ $totalMahasiswa }}</h1>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-6">
    <a href="{{ route('supervisor.kegiatan.index',['status'=>'pending']) }}" class="stat-link">
      <div class="stat-card stat-white">
        <div class="stat-inner">
          <div class="stat-icon" style="background:rgba(15,23,42,.1);">
            <img src="{{ asset('images/logo a.png') }}">
          </div>
          <div class="stat-text">
            <h6>Laporan Menunggu Persetujuan</h6>
            <h1>{{ $pendingKegiatan }}</h1>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>
@endsection
