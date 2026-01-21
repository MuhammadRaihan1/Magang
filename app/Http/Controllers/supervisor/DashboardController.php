<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KegiatanHarian;

class DashboardController extends Controller
{
    public function index()
    {
        // hitung total mahasiswa bimbingan supervisor ini
        $totalMahasiswa = User::where('role', 'mahasiswa')
            ->where('supervisor_id', auth()->id())
            ->count();

        // hitung kegiatan yang masih pending
        $pendingKegiatan = KegiatanHarian::where('status', 'Pending')
            ->whereHas('mahasiswa', function ($query) {
                $query->where('supervisor_id', auth()->id());
            })
            ->count();

        return view('supervisor.dashboard', compact(
            'totalMahasiswa',
            'pendingKegiatan'
        ));
    }
}
