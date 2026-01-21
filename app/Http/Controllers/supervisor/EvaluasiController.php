<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Evaluasi;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function index()
    {
        // hanya mahasiswa bimbingan supervisor ini
        $mahasiswas = User::where('role', 'mahasiswa')
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->get();

        return view('supervisor.evaluasi.index', compact('mahasiswas'));
    }

    public function create(User $mahasiswa)
    {
        // security: supervisor hanya boleh nilai mahasiswa bimbingan sendiri
        abort_if($mahasiswa->role !== 'mahasiswa' || $mahasiswa->supervisor_id !== auth()->id(), 403);

        $evaluasi = Evaluasi::where('mahasiswa_id', $mahasiswa->id)
            ->where('supervisor_id', auth()->id())
            ->first();

        return view('supervisor.evaluasi.create', compact('mahasiswa', 'evaluasi'));
    }

    public function store(Request $request, User $mahasiswa)
    {
        // security: supervisor hanya boleh nilai mahasiswa bimbingan sendiri
        abort_if($mahasiswa->role !== 'mahasiswa' || $mahasiswa->supervisor_id !== auth()->id(), 403);

        // VALIDASI BARU: hanya nilai + catatan
        $validated = $request->validate([
            'nilai'   => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        // simpan: 1 evaluasi per (mahasiswa, supervisor) karena ada unique constraint
        Evaluasi::updateOrCreate(
            [
                'mahasiswa_id'  => $mahasiswa->id,
                'supervisor_id' => auth()->id(),
            ],
            [
                'nilai'   => $validated['nilai'],
                'catatan' => $validated['catatan'] ?? null,
            ]
        );

        return redirect()
            ->route('supervisor.evaluasi.index')
            ->with('success', 'Evaluasi berhasil disimpan.');
    }
}
