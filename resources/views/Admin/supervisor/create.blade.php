@extends('admin.layout')

@section('title', 'Tambah Supervisor')

@section('content')
    <div class="form-card">
        <h2 class="form-title">Tambah Supervisor</h2>

        @if ($errors->any())
            <div class="error">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li style="margin:4px 0;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.supervisor.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" class="input"
                           placeholder="Masukkan nama supervisor" value="{{ old('name') }}" required>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="input"
                           placeholder="Masukkan email supervisor" value="{{ old('email') }}" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="input"
                           placeholder="Masukkan password" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="input" placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <a href="{{ route('admin.supervisor.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
