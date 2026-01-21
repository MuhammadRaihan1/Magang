@extends('supervisor.layout')

@section('content')

<div class="bg-white rounded-4 p-4 mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold">
            Selamat datang Supervisor {{ auth()->user()->name }}
        </h2>
        <h5 class="text-muted">
            Di Website Manajemen Magang
        </h5>
    </div>

    <img src="{{ asset('images/admin-3d.png') }}" alt="Welcome" style="height: 120px;">
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="bg-secondary text-white rounded-4 p-4 text-center">
            <img src="{{ asset('images/logo a.png') }}" width="50" class="mb-3">
            <h5>Total Mahasiswa Bimbingan</h5>
            <h1 class="fw-bold">{{ $totalMahasiswa }}</h1>
        </div>
    </div>

    <div class="col-md-6">
        <div class="bg-white border rounded-4 p-4 text-center">
            <img src="{{ asset('images/logo a.png') }}" width="50" class="mb-3">
            <h5>Laporan Menunggu Persetujuan</h5>
            <h1 class="fw-bold">{{ $pendingKegiatan }}</h1>
        </div>
    </div>
</div>

@endsection
