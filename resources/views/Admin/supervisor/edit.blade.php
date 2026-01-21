@extends('admin.layout')

@section('title', 'Edit Supervisor')

@section('content')
<div class="bn-page">
    <div class="bn-card">
        <div class="bn-card-head">
            <h3>Edit Supervisor</h3>
        </div>

        @if ($errors->any())
            <div class="bn-alert">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.supervisor.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="bn-field">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="bn-field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="bn-field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
            </div>

            <div class="bn-field">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password">
            </div>

            <div class="bn-actions">
                <button type="submit" class="bn-btn bn-btn-primary">Simpan</button>
                <a href="{{ route('admin.supervisor.index') }}" class="bn-btn bn-btn-danger">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Wrapper biar posisinya sama seperti halaman mahasiswa */
    .bn-page{
        padding: 12px 14px;
        width: 100%;
    }

    /* Card putih rounded besar */
    .bn-card{
        background: #fff;
        border-radius: 18px;
        padding: 22px 24px 24px;
        max-width: 760px;
        box-shadow: 0 14px 32px rgba(16, 24, 40, .10);
    }

    .bn-card-head h3{
        margin: 0 0 16px 0;
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Error alert */
    .bn-alert{
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #7f1d1d;
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 14px;
    }
    .bn-alert ul{
        margin: 0;
        padding-left: 18px;
    }

    /* Field layout */
    .bn-field{
        margin-bottom: 14px;
    }
    .bn-field label{
        display: block;
        font-weight: 700;
        margin-bottom: 8px;
        color: #0f172a;
    }
    .bn-field input{
        width: 100%;
        height: 46px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        outline: none;
        font-size: 14px;
        background: #fff;
        transition: .15s ease;
    }
    .bn-field input::placeholder{
        color: #9ca3af;
    }
    .bn-field input:focus{
        border-color: rgba(59, 130, 246, .55);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .12);
    }

    /* Button group */
    .bn-actions{
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .bn-btn{
        height: 44px;
        padding: 0 22px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        text-decoration: none;
        border: 0;
        cursor: pointer;
        transition: .15s ease;
    }

    .bn-btn-primary{
        background: #2f80ed;
        color: #fff;
    }
    .bn-btn-primary:hover{
        filter: brightness(.95);
    }

    .bn-btn-danger{
        background: #dc2626;
        color: #fff;
    }
    .bn-btn-danger:hover{
        filter: brightness(.95);
    }

    /* Responsive */
    @media (max-width: 576px){
        .bn-card{ padding: 18px 16px; }
        .bn-actions{ flex-direction: column; }
        .bn-btn{ width: 100%; }
    }
</style>
@endsection
