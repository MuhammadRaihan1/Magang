@extends('admin.layout')

@section('title','Tambah Supervisor')

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

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.field{
    display:flex;
    flex-direction:column;
}

.field label{
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
    margin-top:20px;
    display:flex;
    gap:10px;
}

.btn{
    background:#3c8dbc;
    color:#fff;
    padding:8px 18px;
    border:none;
    border-radius:4px;
    font-size:14px;
    cursor:pointer;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.btn:hover{
    background:#367fa9;
}

.btn-secondary{
    background:#6c757d;
}

.btn-secondary:hover{
    background:#5a6268;
}

.container,
.container-fluid{
    max-width:100% !important;
    width:100% !important;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="page-wrap">

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
                    <label>Nama</label>
                    <input type="text"
                           name="name"
                           class="input"
                           placeholder="Masukkan nama supervisor"
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="input"
                           placeholder="Masukkan email supervisor"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="field">
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           class="input"
                           placeholder="Masukkan password"
                           required>
                </div>

                <div class="field">
                    <label>Konfirmasi Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="input"
                           placeholder="Ulangi password"
                           required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    Simpan
                </button>

                <a href="{{ route('admin.supervisor.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>

@endsection