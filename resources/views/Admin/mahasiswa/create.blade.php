@extends('admin.layout')

@section('title','Tambah Mahasiswa')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#eef2f6;
    font-family: Arial, Helvetica, sans-serif;
}

.page-wrap{
    padding:20px;
    width:100%;
}

.form-card{
    background:#f4f6f9;
    border:1px solid #d9dee3;
    border-radius:6px;
    padding:20px 22px 24px;
    width:100%;
    max-width:100%;
}

.form-title{
    font-size:20px;
    font-weight:600;
    margin-bottom:18px;
    color:#2f3e4d;
}

.error{
    background:#fdecea;
    border:1px solid #f5c6cb;
    color:#842029;
    padding:10px 14px;
    border-radius:4px;
    margin-bottom:16px;
    font-size:14px;
}

.field{
    margin-bottom:16px;
}

.field label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:6px;
    color:#2f3e4d;
}

.input{
    width:100%;
    height:40px;
    padding:6px 10px;
    border:1px solid #ced4da;
    border-radius:4px;
    background:#fff;
    font-size:14px;
}

.input:focus{
    outline:none;
    border-color:#3c8dbc;
}

.form-actions{
    margin-top:18px;
    display:flex;
    gap:10px;
}

.btn-primary{
    background:#3c8dbc;
    color:#fff;
    padding:8px 18px;
    border:none;
    border-radius:4px;
    font-size:14px;
    cursor:pointer;
}

.btn-primary:hover{
    background:#367fa9;
}

.btn-secondary{
    background:#6c757d;
    color:#fff;
    padding:8px 18px;
    border-radius:4px;
    text-decoration:none;
    font-size:14px;
    display:inline-flex;
    align-items:center;
}

.btn-secondary:hover{
    background:#5a6268;
}

.container,
.container-fluid{
    max-width:100% !important;
    width:100% !important;
}
</style>

<div class="page-wrap">

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

            <div class="field">
                <label>Nama</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="input"
                       placeholder="Masukkan nama mahasiswa"
                       required>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="input"
                       placeholder="contoh@email.com"
                       required>
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="input"
                       placeholder="Minimal 6 karakter"
                       required>
            </div>

            <div class="field">
                <label>Supervisor</label>
                <select name="supervisor_id" class="input">
                    <option value="">-- Pilih Supervisor (Opsional) --</option>
                    @foreach ($supervisors as $spv)
                        <option value="{{ $spv->id }}"
                            {{ old('supervisor_id') == $spv->id ? 'selected' : '' }}>
                            {{ $spv->name }} ({{ $spv->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Simpan
                </button>

                <a href="{{ route('admin.mahasiswa.index') }}"
                   class="btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>

</div>

@endsection