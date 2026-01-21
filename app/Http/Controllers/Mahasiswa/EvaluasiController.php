<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluasi;

class EvaluasiController extends Controller
{
    public function index()
    {
        // Ambil evaluasi milik mahasiswa yang login
        $evaluasis = Evaluasi::where('mahasiswa_id', auth()->id())
            ->with(['supervisor'])
            ->latest()
            ->paginate(10);

        return view('mahasiswa.evaluasi.index', compact('evaluasis'));
    }

    public function show(Evaluasi $evaluasi)
    {
        // Security: mahasiswa hanya boleh lihat evaluasi miliknya
        abort_unless($evaluasi->mahasiswa_id === auth()->id(), 403);

        $evaluasi->load(['supervisor']);

        return view('mahasiswa.evaluasi.show', compact('evaluasi'));
    }
}
