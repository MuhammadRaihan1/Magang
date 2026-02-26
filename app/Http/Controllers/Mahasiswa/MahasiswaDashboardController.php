<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KegiatanHarian;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class MahasiswaDashboardController extends Controller
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
        $user   = $request->user();
        $column = $this->getColumnName();

        $month = $request->month;
        $year  = $request->year;

        if (!$month || !$year) {
            $now = Carbon::now();
        } else {
            $now = Carbon::createFromDate($year, $month, 1);
        }

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth   = $now->copy()->endOfMonth();

        $monthName   = $now->translatedFormat('F');
        $year        = $now->year;
        $daysInMonth = $now->daysInMonth;
        $startOffset = $startOfMonth->dayOfWeekIso - 1;

        $todayDay = (Carbon::now()->month == $now->month && Carbon::now()->year == $now->year)
            ? Carbon::now()->day
            : null;

        $prevMonth = $now->copy()->subMonth()->month;
        $prevYear  = $now->copy()->subMonth()->year;
        $nextMonth = $now->copy()->addMonth()->month;
        $nextYear  = $now->copy()->addMonth()->year;

        $activities = KegiatanHarian::where($column, $user->id)
            ->whereBetween('tanggal', [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString()
            ])
            ->orderBy('tanggal', 'desc')
            ->get();

        $statusByDate = [];

        foreach ($activities as $a) {
            $day = Carbon::parse($a->tanggal)->day;

            $status = method_exists($a, 'getVerifikasiStatus')
                ? $a->getVerifikasiStatus()
                : ($a->status ?? 'pending');

            $statusByDate[$day] = $status;
        }

        $lastActivities = KegiatanHarian::where($column, $user->id)
            ->orderByRaw('COALESCE(verified_at, updated_at, created_at) DESC')
            ->get();

        $today = Carbon::now()->toDateString();

        $laporanHariIni = KegiatanHarian::where($column, $user->id)
            ->whereDate('tanggal', $today)
            ->orderByRaw('COALESCE(verified_at, updated_at, created_at) DESC')
            ->first();

        $penilaian = Penilaian::where('mahasiswa_id', $user->id)
            ->latest()
            ->first();

        return view('mahasiswa.dashboard', compact(
            'lastActivities',
            'activities',
            'statusByDate',
            'penilaian',
            'monthName',
            'year',
            'daysInMonth',
            'startOffset',
            'todayDay',
            'prevMonth',
            'prevYear',
            'nextMonth',
            'nextYear',
            'laporanHariIni'
        ));
    }
}