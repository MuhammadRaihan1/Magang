<x-layouts.auth :leftImage="asset('assets/illustration-right.png')">
    <div class="text-center mb-6">
        <img src="{{ asset('assets/logo.png') }}" class="h-10 mx-auto" alt="Logo">
        <p class="text-white mt-3 font-semibold">Sign In to Management Magang</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-white text-sm mb-1">Username (Email)</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-md px-4 py-3 auth-input focus:ring-2 focus:ring-white"
                placeholder="Masukkan email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-white text-sm mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full rounded-md px-4 py-3 auth-input focus:ring-2 focus:ring-white"
                placeholder="Masukkan password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit"
            class="w-full rounded-full bg-white text-gray-700 font-semibold py-3 mt-3 hover:opacity-95">
            Login
        </button>

        <p class="text-center text-white/90 text-sm mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:underline">
                daftar di sini
            </a>
        </p>
    </form>
</x-layouts.auth>
    