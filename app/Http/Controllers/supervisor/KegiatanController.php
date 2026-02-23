<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\KegiatanHarian;
use App\Models\User;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $supervisorId = auth()->id();
        $statusMagang = $request->status_magang;

        if (!$request->mahasiswa_id) {

            $query = User::with('penilaianTerakhir')
                ->where('role', 'mahasiswa')
                ->where('supervisor_id', $supervisorId);

            if ($statusMagang === 'aktif') {
                $query->whereDoesntHave('penilaians', function ($q) {
                    $q->whereNotNull('nilai_akhir');
                });
            }

            if ($statusMagang === 'selesai') {
                $query->whereHas('penilaians', function ($q) {
                    $q->whereNotNull('nilai_akhir');
                });
            }

            $mahasiswas = $query->latest()->get();

            return view('supervisor.kegiatan.index', compact('mahasiswas'));
        }

        $mahasiswa = User::where('id', $request->mahasiswa_id)
            ->where('supervisor_id', $supervisorId)
            ->firstOrFail();

        $kegiatans = KegiatanHarian::with('mahasiswa')
            ->where('user_id', $mahasiswa->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('supervisor.kegiatan.index', compact('kegiatans', 'mahasiswa'));
    }

    public function show(KegiatanHarian $kegiatan)
    {
        $supervisorId = auth()->id();

        abort_unless(
            $kegiatan->mahasiswa &&
            $kegiatan->mahasiswa->supervisor_id == $supervisorId,
            403
        );

        $kegiatan->load('mahasiswa');

        return view('supervisor.kegiatan.show', compact('kegiatan'));
    }

    public function approve(Request $request, KegiatanHarian $kegiatan)
    {
        $supervisorId = auth()->id();

        abort_unless(
            $kegiatan->mahasiswa &&
            $kegiatan->mahasiswa->supervisor_id == $supervisorId,
            403
        );

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

    public function reject(Request $request, KegiatanHarian $kegiatan)
    {
        $supervisorId = auth()->id();

        abort_unless(
            $kegiatan->mahasiswa &&
            $kegiatan->mahasiswa->supervisor_id == $supervisorId,
            403
        );

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