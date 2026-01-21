@extends('admin.layout')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="form-card">
    <h2 class="form-title">Tambah Mahasiswa Magang</h2>

    @if ($errors->any())
        <div class="error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
        @csrf

        <div class="form-grid">
            <div class="field">
                <label for="name">Nama</label>
                <input id="name" name="name" class="input" type="text"
                       value="{{ old('name') }}" placeholder="Masukkan nama mahasiswa" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" class="input" type="email"
                       value="{{ old('email') }}" placeholder="contoh@email.com" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" class="input" type="password"
                       placeholder="Minimal 6 karakter" required>
            </div>

            {{-- ✅ Supervisor (ditetapkan oleh admin) --}}
            <div class="field">
                <label for="supervisor_id">Supervisor</label>
                <select id="supervisor_id" name="supervisor_id" class="input">
                    <option value="">-- Pilih Supervisor (Opsional) --</option>
                    @foreach ($supervisors as $spv)
                        <option value="{{ $spv->id }}" {{ old('supervisor_id') == $spv->id ? 'selected' : '' }}>
                            {{ $spv->name }} ({{ $spv->email }})
                        </option>
                    @endforeach
                </select>
                @error('supervisor_id') <div class="lap-err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan</button>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
