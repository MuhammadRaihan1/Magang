@extends('layouts.mahasiswa')

@section('title', 'Detail Evaluasi')

@section('content')
<div class="keg-header">
  <h1 class="keg-title">Detail Evaluasi</h1>
</div>

<div class="table-wrap" style="padding:16px;">
  <div style="background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:14px;padding:18px;max-width:980px;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div>
        <div style="font-size:12px;color:#64748b;">Tanggal</div>
        <div style="font-size:14px;color:#0f172a;margin-top:4px;">
          {{ optional($evaluasi->created_at)->format('d-m-Y H:i') }}
        </div>
      </div>

      <div>
        <div style="font-size:12px;color:#64748b;">Supervisor</div>
        <div style="font-size:14px;color:#0f172a;margin-top:4px;">
          {{ $evaluasi->supervisor->name ?? '-' }}
        </div>
      </div>

      <div>
        <div style="font-size:12px;color:#64748b;">Nilai</div>
        <div style="font-size:14px;color:#0f172a;margin-top:4px;">
          {{ $evaluasi->nilai ?? '-' }}
        </div>
      </div>
    </div>

    <div style="margin-top:14px;">
      <div style="font-size:12px;color:#64748b;">Catatan Supervisor</div>
      <div style="margin-top:6px;background:#f8fafc;border:1px solid rgba(0,0,0,.08);border-radius:12px;padding:14px;white-space:pre-wrap;color:#0f172a;">
        {{ $evaluasi->catatan ?? '-' }}
      </div>
    </div>

    <div style="margin-top:16px;display:flex;justify-content:flex-end;">
      <a href="{{ route('mahasiswa.evaluasi.index') }}" class="keg-btn keg-btn--cetak" style="text-decoration:none;">
        Kembali
      </a>
    </div>
  </div>
</div>
@endsection
