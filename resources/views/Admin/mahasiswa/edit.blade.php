@extends('admin.layout')

@section('title', 'Edit Mahasiswa')

@section('content')
  <div class="form-card">
    <h2 class="form-title">Edit Mahasiswa Magang</h2>

    @if ($errors->any())
      <div class="error">
        <ul style="margin:0; padding-left:18px;">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.mahasiswa.update', $user->id) }}">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <div class="field">
          <label for="name">Nama</label>
          <input
            id="name"
            type="text"
            name="name"
            class="input"
            value="{{ old('name', $user->name) }}"
            placeholder="Masukkan nama mahasiswa"
            required
          >
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input
            id="email"
            type="email"
            name="email"
            class="input"
            value="{{ old('email', $user->email) }}"
            placeholder="contoh@email.com"
            required
          >
        </div>

        <div class="field">
          <label for="password">Password </label>
          <input
            id="password"
            type="password"
            name="password"
            class="input"
            placeholder="Kosongkan jika tidak diubah"
          >
        </div>

        <div class="field">
          <label for="password_confirmation">Konfirmasi Password</label>
          <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            class="input"
            placeholder="Ulangi password"
          >
        </div>
      </div>

      <div class="form-actions">
        <button class="btn" type="submit">Simpan</button>
        <a class="btn btn-secondary" href="{{ route('admin.mahasiswa.index') }}">Batal</a>
      </div>
    </form>
  </div>
@endsection
