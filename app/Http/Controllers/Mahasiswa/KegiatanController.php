<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KegiatanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:mahasiswa']);
    }

    private function getColumnName(): string
    {
        if (Schema::hasColumn('kegiatan_harians', 'user_id')) {
            return 'user_id';
        }

        return 'mahasiswa_id';
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $column = $this->getColumnName();

        $kegiatans = KegiatanHarian::where($column, $user->id)
            ->latest()
            ->paginate(10);

        return view('mahasiswa.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('mahasiswa.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'jam_masuk'  => 'nullable',
            'jam_pulang' => 'nullable',
            'aktivitas'  => 'required|string'
        ]);

        $column = $this->getColumnName();

        KegiatanHarian::create([
            $column      => auth()->id(),
            'tanggal'    => $request->tanggal,
            'jam_masuk'  => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'aktivitas'  => $request->aktivitas,
        ]);

        return redirect()->route('mahasiswa.kegiatan.index');
    }

    public function show(KegiatanHarian $kegiatan)
    {
        return view('mahasiswa.kegiatan.show', compact('kegiatan'));
    }

    public function print(Request $request)
    {
        return $this->cetakPdf($request);
    }

    public function cetakPdf(Request $request)
    {
        $user = $request->user();
        $column = $this->getColumnName();

        $kegiatans = KegiatanHarian::where($column, $user->id)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('Mahasiswa.kegiatan.print', [
            'kegiatans' => $kegiatans,
            'user'      => $user,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-kegiatan-' . $user->name . '.pdf');
    }
}