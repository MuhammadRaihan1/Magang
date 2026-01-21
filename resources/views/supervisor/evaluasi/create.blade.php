@extends('supervisor.layout')

@section('content')
<h3 class="fw-bold mb-3">Form Evaluasi: {{ $mahasiswa->name }}</h3>

<div class="bg-white p-4 rounded-4 shadow-sm" style="max-width: 720px;">
    <form method="POST" action="{{ route('supervisor.evaluasi.store', $mahasiswa->id) }}">
        @csrf

        {{-- NILAI (1 FIELD SAJA) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Nilai (0 - 100)</label>
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

        {{-- CATATAN --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan</label>
            <textarea
                name="catatan"
                rows="4"
                class="form-control @error('catatan') is-invalid @enderror"
            >{{ old('catatan', $evaluasi->catatan ?? '') }}</textarea>

            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ACTION --}}
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
@endsection
