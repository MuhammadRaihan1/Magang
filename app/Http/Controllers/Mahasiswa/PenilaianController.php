<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ambil penilaian terakhir mahasiswa yang login
        $penilaian = $user->penilaianTerakhir;

        return view('mahasiswa.penilaian.index', compact('penilaian'));
    }

    public function show($id)
    {
        $user = auth()->user();

        // pastikan mahasiswa hanya bisa lihat penilaiannya sendiri
        $penilaian = $user->penilaians()->findOrFail($id);

        return view('mahasiswa.penilaian.show', compact('penilaian'));
    }
}
