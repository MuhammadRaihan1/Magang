@extends('supervisor.layout')

@section('title', 'Edit Penilaian')

@section('content')
<style>
  .card-clean{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    overflow:hidden;
    box-shadow: 0 1px 2px rgba(15,23,42,.06);
  }
  .tbl th, .tbl td{ vertical-align: middle; }
  .tbl thead th{
    background:#f8fafc;
    border-bottom:1px solid #e5e7eb;
    padding:12px 14px;
    font-size:13px;
  }
  .tbl tbody td{
    padding:12px 14px;
    border-top:1px solid #eef2f7;
    font-size:13px;
  }
  .range{ color:#64748b; font-size:12px; }
  .select-nilai{
    min-width:90px;
    border-radius:10px;
  }

  /* Summary kanan bawah seperti create */
  .summary-wrap{
    display:flex;
    justify-content:flex-end;
    margin-top:18px;
  }
  .summary{
    min-width:320px;
    text-align:right;
  }
  .summary .rowx{
    display:flex;
    justify-content:flex-end;
    gap:20px;
    margin-bottom:14px;
    font-size:13px;
  }
  .summary .label{
    color:#0f172a;
  }
  .summary .value{
    min-width:80px;
  }
  .btn-row{
    display:flex;
    gap:10px;
    margin-top:18px;
  }
</style>

<h2 class="mb-1">NILAI</h2>
<div class="text-muted mb-3">Beranda / Edit Nilai</div>

<div class="mb-3">
  <div><span class="text-muted">Nama Lengkap :</span> {{ $mahasiswa->name }} / {{ $mahasiswa->nim ?? '-' }}</div>
</div>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

@php
  // nilai lama dari DB (array 15)
  $oldNilai = is_array($penilaian->nilai ?? null) ? $penilaian->nilai : [];

  // Pastikan aspek sama seperti create kamu (sesuaikan kalau beda)
  $aspek = [
    "Penguasaan ilmu bidang studi (teori) penunjang praktek",
    "Keterampilan membaca gambar kerja / petunjuk",
    "Keterampilan menggunakan alat / instrumen praktek",
    "Kapasitas hasil praktek sesuai waktu yang disediakan",
    "Kualitas hasil praktek dibanding standar (tolak ukur)",
    "Kemampuan berpraktek secara mandiri",
    "Inisiatif meningkatkan hasil praktek",
    "Inisiatif menyelesaikan / mengatasi masalah",
    "Kerja sama dengan orang lain selama praktek",
    "Disiplin dan kehadiran di tempat praktek",
    "Sikap terhadap petunjuk, kritik, atau anjuran pembimbing",
    "Pelaksanaan program keselamatan kerja",
    "Pemeliharaan keselamatan alat, bahan, dan lingkungan",
    "Kewajaran penampilan dan berpakaian",
    "Tanggung jawab terhadap tugas"
  ];

  // skor awal dari DB
  $initialTotal = (int) ($penilaian->total_skor ?? array_sum($oldNilai));
  $initialAkhir = (float) ($penilaian->nilai_akhir ?? ($initialTotal ? round($initialTotal/15, 2) : 0));
  $initialGrade = $penilaian->grade ?? '-';
@endphp

<form method="POST" action="{{ route('supervisor.penilaian.update', $mahasiswa->id) }}">
  @csrf
  @method('PUT')

  <div class="card-clean">
    <div class="table-responsive">
      <table class="table tbl mb-0">
        <thead>
          <tr>
            <th style="width:70px;" class="text-center">No</th>
            <th>ASPEK YANG DINILAI</th>
            <th style="width:220px;">RANGE PENILAIAN</th>
            <th style="width:160px;" class="text-center">Nilai</th>
          </tr>
        </thead>

        <tbody>
          @foreach($aspek as $i => $label)
            @php
              $val = old("nilai.$i", $oldNilai[$i] ?? '');
            @endphp
            <tr>
              <td class="text-center">{{ $i + 1 }}</td>
              <td>{{ $label }}</td>
              <td class="range">1=20 | 2=40 | 3=60 | 4=80 | 5=100</td>
              <td class="text-center">
                <select name="nilai[{{ $i }}]" class="form-select select-nilai nilai-item" required>
                  <option value="" {{ $val === '' ? 'selected' : '' }}>-</option>
                  <option value="20"  {{ (string)$val === '20'  ? 'selected' : '' }}>20</option>
                  <option value="40"  {{ (string)$val === '40'  ? 'selected' : '' }}>40</option>
                  <option value="60"  {{ (string)$val === '60'  ? 'selected' : '' }}>60</option>
                  <option value="80"  {{ (string)$val === '80'  ? 'selected' : '' }}>80</option>
                  <option value="100" {{ (string)$val === '100' ? 'selected' : '' }}>100</option>
                </select>
              </td>
            </tr>
          @endforeach
        </tbody>

      </table>
    </div>
  </div>

  {{-- Ringkasan skor (seperti create) --}}
  <div class="summary-wrap">
    <div class="summary">
      <div class="rowx">
        <div class="label">TOTAL SKOR</div>
        <div class="value" id="totalSkor">{{ $initialTotal }}</div>
      </div>
      <div class="rowx">
        <div class="label">NILAI AKHIR</div>
        <div class="value" id="nilaiAkhir">{{ number_format($initialAkhir, 2) }}</div>
      </div>
      <div class="rowx" style="margin-bottom:0;">
        <div class="label">GRADE</div>
        <div class="value" id="grade">{{ $initialGrade }}</div>
      </div>
    </div>
  </div>

  <div class="btn-row">
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('supervisor.penilaian.index') }}" class="btn btn-secondary">Kembali</a>
  </div>
</form>

<script>
  function gradeFromScore(nilaiAkhir) {
    if (nilaiAkhir >= 85) return 'A';
    if (nilaiAkhir >= 70) return 'B';
    if (nilaiAkhir >= 55) return 'C';
    if (nilaiAkhir >= 40) return 'D';
    return 'E';
  }

  function recalc() {
    const selects = document.querySelectorAll('.nilai-item');
    let total = 0;
    let count = 0;

    selects.forEach(s => {
      const v = parseInt(s.value, 10);
      if (!isNaN(v)) {
        total += v;
        count++;
      }
    });

    // nilai akhir sesuai controller: total/15
    const nilaiAkhir = total / 15;
    const nilaiAkhirFix = Math.round(nilaiAkhir * 100) / 100;

    document.getElementById('totalSkor').textContent = total;
    document.getElementById('nilaiAkhir').textContent = nilaiAkhirFix.toFixed(2);

    // Grade dihitung dari nilai akhir (rata-rata)
    // Kalau belum lengkap 15, tetap hitung, tapi bisa kamu ubah kalau mau.
    document.getElementById('grade').textContent = gradeFromScore(nilaiAkhirFix);
  }

  document.querySelectorAll('.nilai-item').forEach(s => {
    s.addEventListener('change', recalc);
  });

  // hitung saat load (biar sesuai nilai lama)
  recalc();
</script>
@endsection
