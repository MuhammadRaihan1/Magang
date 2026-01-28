@extends('supervisor.layout')

@section('title', 'Tambah Penilaian')

@section('content')
<style>
  .nilai-table th,
  .nilai-table td {
    font-size: 13px;
    vertical-align: middle;
  }

  .nilai-table th {
    background: #f8fafc;
    text-align: center;
    font-weight: 700;
  }

  .nilai-select {
    width: 90px;
    margin: auto;
  }

  .nilai-total {
    font-weight: 700;
    text-align: center;
  }

  .final-score {
    font-size: 16px;
    font-weight: 800;
  }

  /* RANGE PENILAIAN RATA KIRI */
  .range-left {
    text-align: left !important;
    padding-left: 12px;
  }

  /* 🔥 HAPUS TOTAL SEMUA GARIS DI FOOTER */
  .nilai-table tfoot,
  .nilai-table tfoot tr,
  .nilai-table tfoot th,
  .nilai-table tfoot td {
    border: none !important;
  }

  .nilai-table tfoot tr {
    border-top: none !important;
    border-bottom: none !important;
  }

  .nilai-table tfoot th,
  .nilai-table tfoot td {
    padding-top: 12px;
    padding-bottom: 12px;
    background: transparent !important;
  }
</style>

<h4 class="mb-2">NILAI</h4>
<p class="text-muted mb-3">Beranda / Tambah Nilai</p>

<div class="mb-4">
  <b>Nama Lengkap :</b>
  {{ $mahasiswa->name }} / {{ $mahasiswa->nim ?? '-' }}
</div>

<form method="POST" action="{{ route('supervisor.penilaian.store', $mahasiswa->id) }}">
@csrf

@php
$aspek = [
  'Penguasaan ilmu bidang studi (teori) penunjang praktek',
  'Keterampilan membaca gambar kerja / petunjuk',
  'Keterampilan menggunakan alat / instrumen praktek',
  'Kapasitas hasil praktek sesuai waktu yang disediakan',
  'Kualitas hasil praktek dibanding standar (tolak ukur)',
  'Kemampuan berpraktek secara mandiri',
  'Inisiatif meningkatkan hasil praktek',
  'Inisiatif menyelesaikan / mengatasi masalah',
  'Kerja sama dengan orang lain selama praktek',
  'Disiplin dan kehadiran di tempat praktek',
  'Sikap terhadap petunjuk, kritik, atau anjuran pembimbing',
  'Pelaksanaan program keselamatan kerja',
  'Pemeliharaan keselamatan alat, bahan, dan lingkungan',
  'Kewajaran penampilan dan berpakaian',
  'Nilai Evaluasi',
];
@endphp

<table class="table table-bordered nilai-table">
  <thead>
    <tr>
      <th width="50">No</th>
      <th>ASPEK YANG DINILAI</th>
      <th width="250" class="range-left">RANGE PENILAIAN</th>
      <th width="180">Nilai</th>
    </tr>
  </thead>

  <tbody>
@foreach($aspek as $i => $nama)
<tr>
  <td class="text-center">{{ $i+1 }}</td>
  <td>{{ $nama }}</td>

  <td class="text-muted range-left">
    1=20 | 2=40 | 3=60 | 4=80 | 5=100
  </td>

  <td class="text-center">
    <select name="nilai[{{ $i }}]" class="form-select nilai-select nilai" required>
      <option value="">-</option>
      <option value="20">1 (20)</option>
      <option value="40">2 (40)</option>
      <option value="60">3 (60)</option>
      <option value="80">4 (80)</option>
      <option value="100">5 (100)</option>
    </select>
  </td>
</tr>
@endforeach
  </tbody>

  <tfoot>
    <tr>
      <th colspan="3" class="text-end">TOTAL SKOR</th>
      <th class="nilai-total" id="totalSkor">0</th>
    </tr>
    <tr>
      <th colspan="3" class="text-end">NILAI AKHIR</th>
      <th class="nilai-total" id="nilaiAkhir">0.00</th>
    </tr>
    <tr>
      <th colspan="3" class="text-end">GRADE</th>
      <th class="final-score" id="grade">-</th>
    </tr>
  </tfoot>
</table>

<div class="d-flex gap-2 mt-3">
  <button class="btn btn-success">Simpan Nilai</button>
  <a href="{{ route('supervisor.penilaian.index') }}" class="btn btn-secondary">Kembali</a>
</div>
</form>

<script>
const selects = document.querySelectorAll('.nilai');
const totalBox = document.getElementById('totalSkor');
const nilaiAkhirBox = document.getElementById('nilaiAkhir');
const gradeBox = document.getElementById('grade');

const JUMLAH_ASPEK = 15;

function hitungGrade(nilai){
  if (nilai >= 85) return 'A';
  if (nilai >= 70) return 'B';
  if (nilai >= 55) return 'C';
  if (nilai >= 40) return 'D';
  return 'E';
}

function hitungNilai(){
  let total = 0;
  selects.forEach(s => total += parseInt(s.value || 0));

  const nilaiAkhir = total / JUMLAH_ASPEK;

  totalBox.innerText = total;
  nilaiAkhirBox.innerText = nilaiAkhir.toFixed(2);
  gradeBox.innerText = hitungGrade(nilaiAkhir);
}

selects.forEach(s => s.addEventListener('change', hitungNilai));
</script>
@endsection
