@extends('admin.layout')

@section('title', 'Edit Mahasiswa')

@section('content')

@php
  $spvName = optional($user->supervisor)->name ?? 'Belum dipilih';
@endphp

<div style="max-width:1100px; margin:0 auto;">

  {{-- HEADER (tanpa tombol kembali) --}}
  <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin: 6px 0 14px;">
    <div>
      <div style="font-size:18px; font-weight:600; color:#111827; margin:0;">
        Edit Mahasiswa
      </div>
      <div style="font-size:13px; color:#6b7280; margin-top:4px;">
        Perbarui data mahasiswa dan supervisor (opsional).
      </div>
    </div>
  </div>

  {{-- ERROR --}}
  @if ($errors->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 14px; border-radius:12px; margin-bottom:14px; font-size:14px;">
      <ul style="margin:0; padding-left:18px;">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- GRID --}}
  <div class="mhs-edit-grid"
       style="display:grid; grid-template-columns: 1.7fr 1fr; gap:18px; align-items:start;">

    {{-- FORM CARD --}}
    <div style="background:#fff; border-radius:16px; padding:18px; border:1px solid #e5e7eb; box-shadow:0 6px 18px rgba(0,0,0,0.05);">
      <form method="POST" action="{{ route('admin.mahasiswa.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns:1fr; gap:14px;">

          <div>
            <label for="name" style="display:block; font-size:14px; color:#111827; margin-bottom:6px;">
              Nama
            </label>
            <input id="name" type="text" name="name"
                   value="{{ old('name', $user->name) }}"
                   required
                   style="width:100%; padding:11px 12px; font-size:14px;
                          border:1px solid #e5e7eb; border-radius:12px; outline:none; background:#fff;">
          </div>

          <div>
            <label for="email" style="display:block; font-size:14px; color:#111827; margin-bottom:6px;">
              Email
            </label>
            <input id="email" type="email" name="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   style="width:100%; padding:11px 12px; font-size:14px;
                          border:1px solid #e5e7eb; border-radius:12px; outline:none; background:#fff;">
          </div>

          <div>
            <label for="password" style="display:block; font-size:14px; color:#111827; margin-bottom:6px;">
              Password
            </label>
            <input id="password" type="password" name="password"
                   placeholder="Kosongkan jika tidak diubah"
                   style="width:100%; padding:11px 12px; font-size:14px;
                          border:1px solid #e5e7eb; border-radius:12px; outline:none; background:#fff;">
            <div style="margin-top:6px; font-size:12px; color:#6b7280;">
              Kosongkan jika tidak ingin mengganti password.
            </div>
          </div>

          <div>
            <label for="password_confirmation" style="display:block; font-size:14px; color:#111827; margin-bottom:6px;">
              Konfirmasi Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   placeholder="Ulangi password"
                   style="width:100%; padding:11px 12px; font-size:14px;
                          border:1px solid #e5e7eb; border-radius:12px; outline:none; background:#fff;">
          </div>

          <div>
            <label for="supervisor_id" style="display:block; font-size:14px; color:#111827; margin-bottom:6px;">
              Supervisor (Opsional)
            </label>

            <select id="supervisor_id" name="supervisor_id"
                    style="width:100%; padding:11px 12px; font-size:14px;
                           border:1px solid #e5e7eb; border-radius:12px; outline:none; background:#fff;">
              <option value="">-- Pilih supervisor --</option>

              @foreach ($supervisors as $spv)
                <option value="{{ $spv->id }}"
                        @selected(old('supervisor_id', $user->supervisor_id) == $spv->id)>
                  {{ $spv->name }} ({{ $spv->email }})
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- ACTIONS (tambah tombol kembali di samping batal) --}}
        <div style="display:flex; gap:10px; margin-top:16px; flex-wrap:wrap;">
          <button type="submit"
                  style="padding:9px 16px; border-radius:12px; border:none; cursor:pointer;
                         background:#2563eb; color:#fff; font-size:14px; font-weight:500;">
            Simpan
          </button>

          <a href="{{ route('admin.mahasiswa.index') }}"
             style="padding:9px 16px; border-radius:12px; text-decoration:none; display:inline-flex;
                    align-items:center; justify-content:center; border:1px solid #e5e7eb;
                    background:#fff; color:#111827; font-size:14px; font-weight:500;">
            Batal
          </a>

          <a href="{{ route('admin.mahasiswa.index') }}"
             style="padding:9px 16px; border-radius:12px; text-decoration:none; display:inline-flex;
                    align-items:center; justify-content:center; border:1px solid #e5e7eb;
                    background:#fff; color:#111827; font-size:14px; font-weight:500;">
            Kembali
          </a>
        </div>
      </form>
    </div>

    {{-- INFO CARD --}}
    <div style="background:#fff; border-radius:16px; padding:16px; border:1px solid #e5e7eb; box-shadow:0 6px 18px rgba(0,0,0,0.05);">
      <div style="font-size:14px; color:#111827; font-weight:600; margin-bottom:12px;">
        Info Mahasiswa
      </div>

      <div style="display:flex; justify-content:space-between; gap:10px; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:14px;">
        <span style="color:#6b7280;">Nama</span>
        <span style="color:#111827;">{{ $user->name }}</span>
      </div>

      <div style="display:flex; justify-content:space-between; gap:10px; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:14px;">
        <span style="color:#6b7280;">Email</span>
        <span style="color:#111827;">{{ $user->email }}</span>
      </div>

      <div style="display:flex; justify-content:space-between; gap:10px; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:14px;">
        <span style="color:#6b7280;">Supervisor</span>
        <span style="color:#111827;">{{ $spvName }}</span>
      </div>

      <div style="margin-top:12px; font-size:13px; color:#6b7280; line-height:1.5;">
        Password boleh dikosongkan jika tidak diubah. Supervisor bersifat opsional.
      </div>
    </div>

  </div>

  {{-- RESPONSIVE --}}
  <style>
    @media (max-width: 900px){
      .mhs-edit-grid{ grid-template-columns: 1fr !important; }
    }
  </style>

</div>

@endsection
