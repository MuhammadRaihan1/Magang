<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login & redirect berdasarkan role
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // proses login
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        }

        if ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }

        // jika role tidak dikenal
        Auth::logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Role akun tidak dikenali. Hubungi admin.',
        ]);
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
