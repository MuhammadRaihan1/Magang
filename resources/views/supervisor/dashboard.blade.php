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
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(16,24,40,.12);
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
    background: rgba(255,255,255,.15);
    flex-shrink:0;
  }

  .stat-icon img{
    width:38px;
    height:auto;
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
    line-height:1;
  }

  .stat-white{
    background:#fff;
    border:1px solid #e5e7eb;
  }

  .stat-dark{
    background:#6c757d;
    color:#fff;
  }
</style>

{{-- HEADER --}}
<div class="bg-white rounded-4 p-4 mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold mb-1">
      Selamat datang Supervisor {{ auth()->user()->name }}
    </h2>
    <h5 class="text-muted mb-0">
      Di Website Manajemen Magang
    </h5>
  </div>

  <img src="{{ asset('images/admin-3d.png') }}" alt="Welcome" style="height:120px;">
</div>

{{-- STAT --}}
<div class="row g-4">

  {{-- TOTAL MAHASISWA --}}
  <div class="col-md-6">
    <a href="{{ route('supervisor.mahasiswa.index') }}" class="stat-link">
      <div class="stat-card stat-dark">
        <div class="stat-inner">
          <div class="stat-icon">
            <img src="{{ asset('images/logo a.png') }}" alt="Mahasiswa">
          </div>
          <div class="stat-text">
            <h6>Total Mahasiswa Bimbingan</h6>
            <h1>{{ $totalMahasiswa }}</h1>
          </div>
        </div>
      </div>
    </a>
  </div>

  {{-- LAPORAN PENDING --}}
  <div class="col-md-6">
    <a href="{{ route('supervisor.kegiatan.index', ['status' => 'pending']) }}" class="stat-link">
      <div class="stat-card stat-white">
        <div class="stat-inner">
          <div class="stat-icon" style="background:#f1f5f9;">
            <img src="{{ asset('images/logo a.png') }}" alt="Kegiatan">
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
