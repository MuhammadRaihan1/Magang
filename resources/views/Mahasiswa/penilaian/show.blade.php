@extends('layouts.mahasiswa')

@section('title', 'Detail Penilaian')

@section('content')
<h1>Detail Penilaian</h1>

<div class="card">
  <div class="card-body">
    <p><b>Mahasiswa:</b> {{ $penilaian->mahasiswa->name }}</p>
    <p><b>Supervisor:</b> {{ $penilaian->supervisor->name }}</p>
    <p><b>Tanggal:</b> {{ $penilaian->tanggal ?? '-' }}</p>

    <hr>

    <ul>
      <li>Disiplin: {{ $penilaian->disiplin }}</li>
      <li>Tanggung Jawab: {{ $penilaian->tanggung_jawab }}</li>
      <li>Kerjasama: {{ $penilaian->kerjasama }}</li>
      <li>Inisiatif: {{ $penilaian->inisiatif }}</li>
    </ul>

    <p><b>Rata-rata:</b> {{ $penilaian->rataRata() }}</p>

    <p><b>Catatan:</b><br>{{ $penilaian->catatan ?? '-' }}</p>

    <a href="{{ route('mahasiswa.penilaian.index') }}"
       class="btn btn-secondary">
      Kembali
    </a>
  </div>
</div>
@endsection
