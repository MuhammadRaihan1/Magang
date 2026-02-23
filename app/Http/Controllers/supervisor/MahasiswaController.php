<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $mahasiswas = User::with('penilaianTerakhir')
            ->where('role', 'mahasiswa')
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->get();

        foreach ($mahasiswas as $m) {
            if ($m->penilaianTerakhir && $m->penilaianTerakhir->nilai_akhir != null) {
                $m->status_magang = 'Selesai';
            } else {
                $m->status_magang = 'Aktif';
            }
        }

        if ($status === 'aktif') {
            $mahasiswas = $mahasiswas->where('status_magang', 'Aktif');
        }

        if ($status === 'selesai') {
            $mahasiswas = $mahasiswas->where('status_magang', 'Selesai');
        }

        return view('supervisor.mahasiswa.index', compact('mahasiswas'));
    }
}