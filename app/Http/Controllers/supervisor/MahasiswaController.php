<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = User::where('role', 'mahasiswa')
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->get();

        return view('supervisor.mahasiswa.index', compact('mahasiswas'));
    }
}
