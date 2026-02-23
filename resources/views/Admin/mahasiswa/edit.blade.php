@extends('admin.layout')

@section('title','Edit Mahasiswa')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#e6edf5;
    font-family:"Times New Roman", Times, serif;
}

/* Judul */
.page-title{
    font-size:26px;
    margin:0 6px 14px 6px;
    font-weight:normal;
}

/* Card utama */
.form-box{
    margin:0 3px 20px 3px;
    background:#f8fafc;
    border-radius:16px;
    border:1px solid #cbd5e1;
    overflow:hidden;
    width:calc(100% - 6px);
}

/* Header biru */
.form-header{
    background:#BCC9EE;
    color:#000;
    padding:14px 20px;
    font-size:17px;
}

/* Body */
.form-body{
    padding:20px;
}

/* Error */
.form-alert{
    background:#fee2e2;
    border-left:5px solid #dc2626;
    padding:12px 14px;
    margin:16px;
    border-radius:8px;
}

/* Row */
.form-row{
    display:flex;
    margin-bottom:16px;
}

.form-label{
    width:200px;
    font-size:15px;
}

.form-field{
    flex:1;
}

/* Input */
.form-input{
    width:100%;
    height:42px;
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #cfd8e3;
    font-size:14px;
}

.form-input:focus{
    outline:none;
    border-color:#2563eb;
}

/* Select */
.form-select{
    width:100%;
    height:42px;
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #cfd8e3;
    font-size:14px;
    background:#fff;
}

/* Actions */
.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:20px;
}

.btn-save{
    background:#16a34a;
    color:#fff;
    padding:8px 18px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-size:14px;
}

.btn-cancel{
    background:#dc2626;
    color:#fff;
    padding:8px 18px;
    border-radius:12px;
    text-decoration:none;
    font-size:14px;
}

.btn-save:hover,
.btn-cancel:hover{
    opacity:.9;
}
</style>

<div class="page-title">
    Edit Mahasiswa
</div>

<div class="form-box">

    <div class="form-header">
        Form Edit Mahasiswa
    </div>

    @if ($errors->any())
        <div class="form-alert">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-body">
        <form method="POST" action="{{ route('admin.mahasiswa.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-label">Nama</div>
                <div class="form-field">
                    <input type="text" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Email</div>
                <div class="form-field">
                    <input type="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Password</div>
                <div class="form-field">
                    <input type="password" name="password"
                           placeholder="Kosongkan jika tidak diubah"
                           class="form-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Konfirmasi Password</div>
                <div class="form-field">
                    <input type="password" name="password_confirmation"
                           placeholder="Ulangi password"
                           class="form-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Supervisor (Opsional)</div>
                <div class="form-field">
                    <select name="supervisor_id" class="form-select">
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

            <div class="form-actions">
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>

@endsection