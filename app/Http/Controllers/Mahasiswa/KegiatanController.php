<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KegiatanHarian;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $kegiatans = KegiatanHarian::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('mahasiswa.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('mahasiswa.kegiatan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal'    => ['required', 'date'],
            'jam_masuk'  => ['nullable'],
            'jam_pulang' => ['nullable'],
            'aktivitas'  => ['required', 'string', 'min:3'],
            'lampiran'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = 'Pending';

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('kegiatan', $filename, 'public');
            $data['lampiran'] = $filename;
        }

        KegiatanHarian::create($data);

        return redirect()
            ->route('mahasiswa.kegiatan.index')
            ->with('success', 'Laporan kegiatan berhasil disimpan (Pending).');
    }

    public function show(KegiatanHarian $kegiatan)
    {
        abort_unless($kegiatan->user_id === auth()->id(), 403);

        return view('mahasiswa.kegiatan.show', compact('kegiatan'));
    }

    public function print()
    {
        $kegiatans = KegiatanHarian::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('mahasiswa.kegiatan.print', compact('kegiatans'));
    }
}
