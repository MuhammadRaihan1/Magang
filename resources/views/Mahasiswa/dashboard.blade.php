@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<style>
  .dash-wrapper{
    width:100%;
    min-height:70vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
  }

  .dash-card{
    width:100%;
    max-width:1100px;
    min-height:380px;
    border-radius:32px;
    padding:4.5rem 5rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:#fff;
    background: linear-gradient(
      135deg,
      #2563eb,
      #dc2626,
      #9333ea,
      #0d9488
    );
    background-size:300% 300%;
    animation: gradientMove 14s ease infinite;
    box-shadow:0 30px 60px rgba(0,0,0,.2);
  }

  .dash-text{
    max-width:60%;
  }

  .dash-title{
    font-size:56px;
    font-weight:900;
    line-height:1.2;
    margin-bottom:16px;
  }

  .dash-subtitle{
    font-size:22px;
    font-weight:500;
    opacity:.95;
  }

  .dash-img{
    height:240px;
  }

  @keyframes gradientMove{
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
  }

  @media(max-width:992px){
    .dash-card{
      flex-direction:column;
      text-align:center;
      padding:3.5rem 2.5rem;
      gap:28px;
    }

    .dash-text{
      max-width:100%;
    }

    .dash-title{
      font-size:40px;
    }

    .dash-subtitle{
      font-size:18px;
    }

    .dash-img{
      height:180px;
    }
  }
</style>

<div class="dash-wrapper">
  <div class="dash-card">
    <div class="dash-text">
      <h1 class="dash-title">
        Selamat datang {{ auth()->user()->name }}
      </h1>
      <h2 class="dash-subtitle">
        Di Website Manajemen Magang
      </h2>
    </div>

    <img
      class="dash-img"
      src="{{ asset('images/admin-3d.png') }}"
      alt="Ilustrasi"
    >
  </div>
</div>
@endsection
