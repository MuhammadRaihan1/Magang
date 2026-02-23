@extends('layouts.mahasiswa')

@section('title','Tambah Laporan Kegiatan')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#e6edf5;
    font-family:"Times New Roman", Times, serif;
}

.page-title{
    font-size:22px;
    margin:0 10px 12px 10px;
    font-weight:normal;
}

.form-card{
    background:#f8fafc;
    margin:0 10px 15px 10px;
    padding:20px 25px;
    border-radius:8px;
    border:1px solid #cbd5e1;
    width:calc(100% - 20px);
}

.form-group{
    margin-bottom:14px;
}

.form-label{
    font-size:14px;
    margin-bottom:4px;
}

.form-control{
    width:100%;
    padding:6px 8px;
    border:1px solid #cbd5e1;
    border-radius:4px;
    font-size:13px;
    background:#ffffff;
    cursor:pointer;
}

.form-control:focus{
    outline:none;
    border-color:#9BA9C4;
}

textarea.form-control{
    resize:vertical;
}

.form-hint{
    font-size:11px;
    color:#666;
    margin-top:3px;
}

.form-error{
    font-size:11px;
    color:#dc2626;
    margin-top:3px;
}

.form-actions{
    margin-top:20px;
}

.btn-back{
    background:#dc2626;
    color:#ffffff;
    padding:6px 15px;
    border:none;
    border-radius:5px;
    text-decoration:none;
    font-size:13px;
    margin-right:6px;
}

.btn-save{
    background:#2563eb;
    color:#ffffff;
    padding:6px 15px;
    border:none;
    border-radius:5px;
    font-size:13px;
}

/* 🔵 TABLE DIPERKECIL */
.report-table{
    width:100%;
    border-collapse:collapse;
    background:#ffffff;
    font-size:13px;
}

.report-table th,
.report-table td{
    border:1px solid #cfd8e3;
    padding:6px 8px;
}

.report-table th{
    background:#eef2f7;
    font-weight:normal;
}
</style>

<div class="page-title">
    Tambah Laporan Kegiatan
</div>

<div class="form-card">

<form method="POST" action="{{ route('mahasiswa.kegiatan.store') }}" enctype="multipart/form-data">
@csrf

<div class="form-group">
    <div class="form-label">Tanggal</div>
    <input id="tanggal" class="form-control" type="date" name="tanggal" value="{{ old('tanggal') }}" required>
    @error('tanggal') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <div class="form-label">Jam Masuk</div>
    <input id="jam_masuk" class="form-control" type="time" name="jam_masuk" value="{{ old('jam_masuk') }}">
    @error('jam_masuk') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <div class="form-label">Jam Pulang</div>
    <input id="jam_pulang" class="form-control" type="time" name="jam_pulang" value="{{ old('jam_pulang') }}">
    @error('jam_pulang') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <div class="form-label">Aktivitas</div>
    <textarea class="form-control" name="aktivitas" rows="4" required>{{ old('aktivitas') }}</textarea>
    @error('aktivitas') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <div class="form-label">Nama Supervisor</div>
    <input class="form-control" type="text" value="{{ auth()->user()->supervisor->name ?? '-' }}" readonly>
    <div class="form-hint">Supervisor ditetapkan oleh Admin.</div>
</div>

<div class="form-group">
    <div class="form-label">Foto / Data Pendukung</div>
    <input class="form-control" type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf">
    @error('lampiran') <div class="form-error">{{ $message }}</div> @enderror
    <div class="form-hint">Opsional. Format: JPG/PNG/PDF</div>
</div>

<div class="form-actions">
    <a href="{{ route('mahasiswa.kegiatan.index') }}" class="btn-back">Kembali</a>
    <button type="submit" class="btn-save">Simpan</button>
</div>

</form>

</div>

{{-- 🔥 SCRIPT AGAR INPUT BISA DIKLIK DIMANA SAJA --}}
<script>
document.getElementById('tanggal').addEventListener('click', function(){
    this.showPicker && this.showPicker();
});
document.getElementById('jam_masuk').addEventListener('click', function(){
    this.showPicker && this.showPicker();
});
document.getElementById('jam_pulang').addEventListener('click', function(){
    this.showPicker && this.showPicker();
});
</script>

@endsection