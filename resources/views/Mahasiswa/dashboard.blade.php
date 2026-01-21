@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')
  <div class="dash-center">
    <div class="dash-card">
      <div class="dash-text">
        <h1 class="dash-title">Selamat datang</h1>
        <h2 class="dash-subtitle">Di Website Manajemen Magang</h2>
      </div>

      <img
        class="dash-img"
        src="{{ asset('images/admin-3d.png') }}"
        alt="Ilustrasi"
      >
    </div>
  </div>
@endsection
