<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\KegiatanHarian;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $supervisorId = auth()->id();

        $query = KegiatanHarian::with('mahasiswa')
            ->whereHas('mahasiswa', function ($q) use ($supervisorId) {
                $q->where('supervisor_id', $supervisorId);
            })
            ->orderBy('tanggal', 'desc');

        // optional filter status (?status=Pending/Approved/Rejected)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatans = $query->paginate(10)->withQueryString();

        return view('supervisor.kegiatan.index', compact('kegiatans'));
    }

    // DETAIL laporan
    public function show(KegiatanHarian $kegiatan)
    {
        $supervisorId = auth()->id();

        // pastikan kegiatan ini milik mahasiswa bimbingan supervisor yang login
        abort_unless(
            $kegiatan->mahasiswa && $kegiatan->mahasiswa->supervisor_id == $supervisorId,
            403
        );

        $kegiatan->load('mahasiswa');

        return view('supervisor.kegiatan.show', compact('kegiatan'));
    }

    // APPROVE
    public function approve(Request $request, KegiatanHarian $kegiatan)
    {
        $supervisorId = auth()->id();
        abort_unless($kegiatan->mahasiswa && $kegiatan->mahasiswa->supervisor_id == $supervisorId, 403);

        $data = $request->validate([
            'catatan_supervisor' => 'nullable|string|max:2000',
        ]);

        $kegiatan->status = 'Approved';
        $kegiatan->catatan_supervisor = $data['catatan_supervisor'] ?? null;
        $kegiatan->save();

        return redirect()
            ->route('supervisor.kegiatan.show', $kegiatan->id)
            ->with('success', 'Laporan berhasil disetujui.');
    }

    // REJECT
    public function reject(Request $request, KegiatanHarian $kegiatan)
    {
        $supervisorId = auth()->id();
        abort_unless($kegiatan->mahasiswa && $kegiatan->mahasiswa->supervisor_id == $supervisorId, 403);

        $data = $request->validate([
            'catatan_supervisor' => 'required|string|max:2000',
        ]);

        $kegiatan->status = 'Rejected';
        $kegiatan->catatan_supervisor = $data['catatan_supervisor'];
        $kegiatan->save();

        return redirect()
            ->route('supervisor.kegiatan.show', $kegiatan->id)
            ->with('success', 'Laporan berhasil ditolak.');
    }
}
