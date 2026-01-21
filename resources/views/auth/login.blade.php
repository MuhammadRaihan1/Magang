@extends('layouts.auth', ['leftImage' => asset('images/logo.png')])

@section('content')
    <div class="text-center mb-8">
        <img src="{{ asset('images/bank.png') }}" class="h-10 mx-auto" alt="Bank Nagari">
        <p class="text-white/90 mt-4 font-semibold tracking-wide">
            Sign In to Management Magang
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-white text-sm mb-2">Username (Email)</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-md px-4 py-3 auth-input"
                placeholder="Masukkan email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-white text-sm mb-2">Password</label>
            <input type="password" name="password" required
                class="w-full rounded-md px-4 py-3 auth-input"
                placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="auth-btn">
            Login
        </button>

        <p class="text-center text-white/90 text-sm mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:underline">
                daftar di sini
            </a>
        </p>
    </form>
@endsection
    