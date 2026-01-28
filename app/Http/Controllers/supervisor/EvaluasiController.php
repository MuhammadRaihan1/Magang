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
        $mahasiswas = User::where('role', 'mahasiswa')
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->get();

        $evaluasiMap = Evaluasi::where('supervisor_id', auth()->id())
            ->whereIn('mahasiswa_id', $mahasiswas->pluck('id'))
            ->get()
            ->keyBy('mahasiswa_id');

        return view('supervisor.evaluasi.index', compact('mahasiswas', 'evaluasiMap'));
    }

    public function create(User $mahasiswa)
    {
        abort_if($mahasiswa->role !== 'mahasiswa' || $mahasiswa->supervisor_id !== auth()->id(), 403);

        $evaluasi = Evaluasi::where('mahasiswa_id', $mahasiswa->id)
            ->where('supervisor_id', auth()->id())
            ->first();

        return view('supervisor.evaluasi.create', compact('mahasiswa', 'evaluasi'));
    }

    public function store(Request $request, User $mahasiswa)
    {
        abort_if($mahasiswa->role !== 'mahasiswa' || $mahasiswa->supervisor_id !== auth()->id(), 403);

        $validated = $request->validate([
            'nilai'   => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:5000',
        ]);

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
