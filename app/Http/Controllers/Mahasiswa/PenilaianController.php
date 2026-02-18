<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $penilaian = $user->penilaianTerakhir;

        return view('mahasiswa.penilaian.index', compact('penilaian'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $penilaian = $user->penilaians()->findOrFail($id);

        return view('mahasiswa.penilaian.show', compact('penilaian'));
    }

    public function cetakPdf()
    {
        $user = auth()->user();

        $penilaian = Penilaian::where('mahasiswa_id', $user->id)
            ->latest()
            ->firstOrFail();

        $pdf = Pdf::loadView('mahasiswa.penilaian.pdf', [
            'mahasiswa' => $user,
            'penilaian' => $penilaian,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('hasil-nilai-' . $user->name . '.pdf');
    }
}
