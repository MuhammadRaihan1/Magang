@extends('supervisor.layout')

@section('content')
<style>
    .form-wrap{
        width: 100%;
        max-width: 1100px;
    }
    .form-card{
        width: 100%;
        background: #fff;
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,.06);
    }
    .form-card .card-head{
        padding: 16px 18px;
        border-bottom: 1px solid rgba(0,0,0,.06);
        background: #f8f9fa;
    }
    .form-card .card-body{
        padding: 18px;
    }
    .form-label{
        font-weight: 600;
    }
</style>

<div class="form-wrap">
    <div class="d-flex align-items-start justify-content-between mb-3">
        <div>
            <h3 class="mb-1">Form Evaluasi</h3>
            <div class="text-muted">Mahasiswa: {{ $mahasiswa->name }}</div>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="card-head">
            <div class="text-muted small">Isi nilai dan catatan evaluasi untuk mahasiswa</div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('supervisor.evaluasi.store', $mahasiswa->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nilai (0 - 100)</label>
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

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea
                        name="catatan"
                        rows="5"
                        class="form-control @error('catatan') is-invalid @enderror"
                        placeholder="Tulis catatan evaluasi..."
                    >{{ old('catatan', $evaluasi->catatan ?? '') }}</textarea>

                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('supervisor.evaluasi.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
