<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->with('supervisor')
            ->latest()
            ->get();

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        $supervisors = User::where('role', 'supervisor')
            ->orderBy('name')
            ->get();

        return view('admin.mahasiswa.create', compact('supervisors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'min:6'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
        ]);

        // kalau supervisor_id diisi, pastikan itu benar role supervisor
        if (!empty($validated['supervisor_id'])) {
            $isSupervisor = User::where('id', $validated['supervisor_id'])
                ->where('role', 'supervisor')
                ->exists();

            if (!$isSupervisor) {
                return back()
                    ->withErrors(['supervisor_id' => 'Supervisor tidak valid.'])
                    ->withInput();
            }
        }

        User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'role'          => 'mahasiswa',
            'supervisor_id' => $validated['supervisor_id'] ?? null,
        ]);

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        abort_if($user->role !== 'mahasiswa', 404);

        $supervisors = User::where('role', 'supervisor')
            ->orderBy('name')
            ->get();

        return view('admin.mahasiswa.edit', compact('user', 'supervisors'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'mahasiswa', 404);

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'      => ['nullable', 'min:6', 'confirmed'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
        ]);

        if (!empty($validated['supervisor_id'])) {
            $isSupervisor = User::where('id', $validated['supervisor_id'])
                ->where('role', 'supervisor')
                ->exists();

            if (!$isSupervisor) {
                return back()
                    ->withErrors(['supervisor_id' => 'Supervisor tidak valid.'])
                    ->withInput();
            }
        }

        $user->name          = $validated['name'];
        $user->email         = $validated['email'];
        $user->supervisor_id = $validated['supervisor_id'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'mahasiswa', 404);

        $user->delete();

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
