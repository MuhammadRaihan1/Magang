<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = User::where('role', 'supervisor')->latest()->get();
        return view('admin.supervisor.index', compact('supervisors'));
    }
    
    public function create()
    {
        return view('admin.supervisor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'supervisor',
        ]);

        return redirect()
            ->route('admin.supervisor.index')
            ->with('success', 'Supervisor berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        // Pastikan yang diedit memang supervisor
        abort_if($user->role !== 'supervisor', 404);

        return view('admin.supervisor.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'supervisor', 404);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.supervisor.index')
            ->with('success', 'Supervisor berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'supervisor', 404);

        $user->delete();

        return redirect()
            ->route('admin.supervisor.index')
            ->with('success', 'Supervisor berhasil dihapus.');
    }
}
