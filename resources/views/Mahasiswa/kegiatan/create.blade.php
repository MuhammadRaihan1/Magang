<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Laporan Kegiatan</title>
  @vite(['resources/css/app.css'])
</head>

<body class="dash-page">
  <div class="dash-wrap">

    <aside class="dash-sidebar">
      <div class="dash-brand">
        <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari" class="dash-brand-logo">
      </div>

      <div class="dash-menu">
        <div class="dash-section-title">LAYANAN</div>
        <a class="dash-link active" href="{{ route('mahasiswa.kegiatan.index') }}">
          <span class="dash-ico">🧾</span> Laporan Kegiatan
        </a>
      </div>
    </aside>

    <main class="dash-main">
      <div class="dash-topbar">
        <div></div>
        <div class="dash-topbar-name">{{ auth()->user()->name ?? 'Nama' }}</div>
      </div>

      <div class="dash-content">
        <h1 class="page-title">Tambah Laporan Kegiatan</h1>

        <form class="lap-card" method="POST" action="{{ route('mahasiswa.kegiatan.store') }}" enctype="multipart/form-data">
          @csrf

          {{-- Tanggal --}}
          <div class="lap-row">
            <div class="lap-label">Tanggal</div>
            <div class="lap-field">
              <div class="lap-input-icon">
                <span class="lap-ico">📅</span>
                <input class="lap-input" type="date" name="tanggal" value="{{ old('tanggal') }}" required>
              </div>
              @error('tanggal') <div class="lap-err">{{ $message }}</div> @enderror
            </div>
          </div>

          {{-- Jam Masuk --}}
          <div class="lap-row">
            <div class="lap-label">Jam Masuk</div>
            <div class="lap-field">
              <div class="lap-input-icon">
                <span class="lap-ico">🕒</span>
                <input class="lap-input" type="time" name="jam_masuk" value="{{ old('jam_masuk') }}">
              </div>
              @error('jam_masuk') <div class="lap-err">{{ $message }}</div> @enderror
            </div>
          </div>

          {{-- Jam Pulang --}}
          <div class="lap-row">
            <div class="lap-label">Jam Pulang</div>
            <div class="lap-field">
              <div class="lap-input-icon">
                <span class="lap-ico">🕒</span>
                <input class="lap-input" type="time" name="jam_pulang" value="{{ old('jam_pulang') }}">
              </div>
              @error('jam_pulang') <div class="lap-err">{{ $message }}</div> @enderror
            </div>
          </div>

          {{-- Aktivitas --}}
          <div class="lap-row">
            <div class="lap-label">Aktivitas</div>
            <div class="lap-field">
              <textarea class="lap-textarea" name="aktivitas" rows="6" placeholder="Masukkan Detail Aktivitas" required>{{ old('aktivitas') }}</textarea>
              @error('aktivitas') <div class="lap-err">{{ $message }}</div> @enderror
            </div>
          </div>

          {{-- Supervisor (Otomatis, tidak bisa diubah mahasiswa) --}}
          <div class="lap-row">
            <div class="lap-label">Nama<br>Supervisor</div>
            <div class="lap-field">
              <input
                class="lap-input"
                type="text"
                value="{{ auth()->user()->supervisor->name ?? '-' }}"
                readonly
              >
              <div class="lap-hint">
                Supervisor ditetapkan oleh Admin.
              </div>
            </div>
          </div>

          {{-- Foto/Data Pendukung --}}
          <div class="lap-row">
            <div class="lap-label">Foto/<br>Data Pendukung</div>
            <div class="lap-field">
              <input class="lap-input-file" type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf">
              @error('lampiran') <div class="lap-err">{{ $message }}</div> @enderror
              <div class="lap-hint">Opsional. Format: JPG/PNG/PDF</div>
            </div>
          </div>

          <div class="lap-actions-right">
            <a href="{{ route('mahasiswa.kegiatan.index') }}" class="btn-back-red">Kembali</a>
            <button type="submit" class="btn-save-red">Simpan</button>
          </div>
        </form>

      </div>
    </main>

  </div>
</body>
</html>
