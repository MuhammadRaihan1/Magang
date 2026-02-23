<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $statusNilai = $request->status_nilai;

        $query = User::where('role', 'mahasiswa')
            ->where('supervisor_id', auth()->id())
            ->with(['penilaians' => function ($q) {
                $q->latest()->limit(1);
            }]);

        if ($statusNilai === 'sudah') {
            $query->whereHas('penilaians', function ($q) {
                $q->whereNotNull('nilai_akhir');
            });
        }

        if ($statusNilai === 'belum') {
            $query->whereDoesntHave('penilaians', function ($q) {
                $q->whereNotNull('nilai_akhir');
            });
        }

        $mahasiswa = $query->latest()->get();

        return view('supervisor.penilaian.index', compact('mahasiswa'));
    }

    public function create(User $mahasiswa)
    {
        return view('supervisor.penilaian.create', compact('mahasiswa'));
    }

    public function store(Request $request, User $mahasiswa)
    {
        $validated = $request->validate([
            'nilai'   => ['required', 'array', 'size:15'],
            'nilai.*' => ['required', 'integer', 'in:20,40,60,80,100'],
        ]);

        $nilai = array_values($validated['nilai']);

        $totalSkor  = array_sum($nilai);
        $nilaiAkhir = round($totalSkor / 15, 2);
        $grade      = $this->gradeFromScore($nilaiAkhir);

        Penilaian::create([
            'mahasiswa_id'  => $mahasiswa->id,
            'supervisor_id' => auth()->id(),
            'nilai'         => $nilai,
            'total_skor'    => $totalSkor,
            'nilai_akhir'   => $nilaiAkhir,
            'grade'         => $grade,
            'tanggal'       => now()->toDateString(),
        ]);

        return redirect()
            ->route('supervisor.penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function show(User $mahasiswa)
    {
        $penilaian = Penilaian::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->firstOrFail();

        return view('supervisor.penilaian.show', compact('mahasiswa', 'penilaian'));
    }

    public function edit(User $mahasiswa)
    {
        $penilaian = Penilaian::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->firstOrFail();

        return view('supervisor.penilaian.edit', compact('mahasiswa', 'penilaian'));
    }

    public function update(Request $request, User $mahasiswa)
    {
        $penilaian = Penilaian::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->firstOrFail();

        $validated = $request->validate([
            'nilai'   => ['required', 'array', 'size:15'],
            'nilai.*' => ['required', 'integer', 'in:20,40,60,80,100'],
        ]);

        $nilai = array_values($validated['nilai']);

        $totalSkor  = array_sum($nilai);
        $nilaiAkhir = round($totalSkor / 15, 2);
        $grade      = $this->gradeFromScore($nilaiAkhir);

        $penilaian->update([
            'nilai'       => $nilai,
            'total_skor'  => $totalSkor,
            'nilai_akhir' => $nilaiAkhir,
            'grade'       => $grade,
            'tanggal'     => now()->toDateString(),
        ]);

        return redirect()
            ->route('supervisor.penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function cetakPdf(User $mahasiswa)
    {
        $penilaian = Penilaian::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->firstOrFail();

        $pdf = Pdf::loadView('supervisor.penilaian.pdf', [
            'mahasiswa' => $mahasiswa,
            'penilaian' => $penilaian,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('hasil-nilai-' . $mahasiswa->name . '.pdf');
    }

    private function gradeFromScore(float $nilai): string
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 55) return 'C';
        if ($nilai >= 40) return 'D';
        return 'E';
    }
}