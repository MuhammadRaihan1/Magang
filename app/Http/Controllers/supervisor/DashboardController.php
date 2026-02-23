<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KegiatanHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $supervisorId = auth()->id();

        $totalMahasiswa = User::where('role', 'mahasiswa')
            ->where('supervisor_id', $supervisorId)
            ->count();

        $pendingKegiatan = KegiatanHarian::whereRaw('LOWER(status) = ?', ['pending'])
            ->whereHas('mahasiswa', function ($q) use ($supervisorId) {
                $q->where('supervisor_id', $supervisorId);
            })
            ->count();

        $recentKegiatan = KegiatanHarian::with('mahasiswa')
            ->whereHas('mahasiswa', function ($q) use ($supervisorId) {
                $q->where('supervisor_id', $supervisorId);
            })
            ->orderByRaw('COALESCE(tanggal, DATE(created_at)) DESC')
            ->limit(8)
            ->get();

        $month = request()->month;
        $year  = request()->year;

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
        $todayDay    = Carbon::now()->month == $now->month && Carbon::now()->year == $now->year
                        ? Carbon::now()->day
                        : null;

        $prevMonth = $now->copy()->subMonth()->month;
        $prevYear  = $now->copy()->subMonth()->year;
        $nextMonth = $now->copy()->addMonth()->month;
        $nextYear  = $now->copy()->addMonth()->year;

        $pendingDays = [];

        $pendingReportsInMonth = KegiatanHarian::select(
                DB::raw('COALESCE(tanggal, DATE(created_at)) as tgl')
            )
            ->whereRaw('LOWER(status) = ?', ['pending'])
            ->whereHas('mahasiswa', function ($q) use ($supervisorId) {
                $q->where('supervisor_id', $supervisorId);
            })
            ->whereBetween(DB::raw('COALESCE(tanggal, DATE(created_at))'), [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString()
            ])
            ->get();

        foreach ($pendingReportsInMonth as $r) {
            if (empty($r->tgl)) continue;
            $day = Carbon::parse($r->tgl)->day;
            $pendingDays[$day] = true;
        }

        return view('supervisor.dashboard', compact(
            'totalMahasiswa',
            'pendingKegiatan',
            'recentKegiatan',
            'pendingDays',
            'monthName',
            'year',
            'daysInMonth',
            'startOffset',
            'todayDay',
            'prevMonth',
            'prevYear',
            'nextMonth',
            'nextYear'
        ));
    }
}