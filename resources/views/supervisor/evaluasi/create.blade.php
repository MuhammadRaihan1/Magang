@extends('supervisor.layout')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* WRAPPER */
  .form-wrap{
    width:100%;
    max-width:1100px;
  }

  /* PAGE HEADER */
  .page-header{
    margin-bottom:18px;
  }

  .page-header h3{
    margin:0;
    font-size:26px;
    font-weight:900;
    color:#0f172a;
  }

  .page-header p{
    margin-top:6px;
    color:#64748b;
    font-size:15px;
  }

  /* CARD */
  .form-card{
    width:100%;
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 22px 45px rgba(15,23,42,.08);
    overflow:hidden;
  }

  .form-card .card-head{
    padding:18px 22px;
    background:#c7d2fe;
  }

  .form-card .card-head span{
    font-size:14px;
    font-weight:700;
    color:#1e293b;
  }

  .form-card .card-body{
    padding:26px;
  }

  /* FORM */
  .form-label{
    font-weight:700;
    color:#0f172a;
    margin-bottom:6px;
  }

  .form-control{
    border-radius:12px;
    padding:10px 14px;
    font-size:15px;
  }

  .form-control:focus{
    box-shadow:0 0 0 .2rem rgba(37,99,235,.15);
    border-color:#2563eb;
  }

  textarea.form-control{
    resize:vertical;
  }

  /* BUTTON */
  .btn{
    border-radius:999px;
    padding:8px 22px;
    font-weight:700;
    font-size:14px;
  }

  .btn-primary{
    background:#2563eb;
    border:none;
  }

  .btn-primary:hover{
    background:#1e40af;
  }

  .btn-secondary{
    background:#e5e7eb;
    border:none;
    color:#0f172a;
  }

  .btn-secondary:hover{
    background:#d1d5db;
  }

  @media(max-width:768px){
    .form-card .card-body{
      padding:20px;
    }

    .page-header h3{
      font-size:22px;
    }
  }
</style>

<div class="form-wrap">

  {{-- PAGE HEADER --}}
  <div class="page-header">
    <h3>Form Evaluasi</h3>
    <p>Mahasiswa: <strong>{{ $mahasiswa->name }}</strong></p>
  </div>

  {{-- CARD --}}
  <div class="form-card">

    <div class="card-head">
      <span>Isi nilai dan catatan evaluasi untuk mahasiswa</span>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('supervisor.evaluasi.store', $mahasiswa->id) }}">
        @csrf

        <div class="mb-4">
          <label class="form-label">Nilai (0 – 100)</label>
          <input
            type="number"
            name="nilai"
            min="0"
            max="100"
            required
            class="form-control @error('nilai') is-invalid @enderror"
            value="{{ old('nilai', $evaluasi->nilai ?? '') }}"
          >
          @error('nilai')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4">
          <label class="form-label">Catatan Evaluasi</label>
          <textarea
            name="catatan"
            rows="5"
            class="form-control @error('catatan') is-invalid @enderror"
            placeholder="Tulis catatan evaluasi mahasiswa..."
          >{{ old('catatan', $evaluasi->catatan ?? '') }}</textarea>

          @error('catatan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex gap-3">
          <a href="{{ route('supervisor.evaluasi.index') }}" class="btn btn-secondary">
            Kembali
          </a>
          <button type="submit" class="btn btn-primary">
            Simpan Evaluasi
          </button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
