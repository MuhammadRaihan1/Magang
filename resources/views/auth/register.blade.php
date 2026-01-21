@extends('layouts.auth', ['leftImage' => asset('images/logo.png')])

@section('content')
@vite(['resources/css/app.css', 'resources/js/app.js'])

    <div class="auth-header">
        <img src="{{ asset('images/bank.png') }}" alt="Bank Nagari">
        <div class="auth-title">REGISTER</div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="auth-field">
            <label class="auth-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="auth-input" placeholder="Masukkan nama lengkap">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="auth-field">
            <label class="auth-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="auth-input" placeholder="Contoh@domain.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="auth-field">
            <label class="auth-label">Password</label>
            <input type="password" name="password" required
                   class="auth-input" placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="auth-field">
            <label class="auth-label">Confirm password</label>
            <input type="password" name="password_confirmation" required
                   class="auth-input" placeholder="Konfirmasi Password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="auth-btn">Register</button>

        {{-- INI YANG KAMU MAU (pasti muncul) --}}
        <div class="auth-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">login di sini</a>
        </div>

        <div class="auth-home">
            <a href="{{ url('/') }}">Halaman Utama (Home)</a>
        </div>
    </form>
    
@endsection
