<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;

class MonitoringController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::with('mahasiswa')
            ->latest()
            ->get();

        return view('supervisor.monitoring.index', compact('kegiatans'));
    }

    public function approve(Kegiatan $kegiatan)
    {
        $kegiatan->update([
            'status' => 'Disetujui',
            'supervisor_id' => auth()->id()
        ]);

        return back()->with('success', 'Kegiatan disetujui');
    }

    public function reject(Kegiatan $kegiatan)
    {
        $kegiatan->update([
            'status' => 'Ditolak',
            'supervisor_id' => auth()->id()
        ]);

        return back()->with('success', 'Kegiatan ditolak');
    }
}
