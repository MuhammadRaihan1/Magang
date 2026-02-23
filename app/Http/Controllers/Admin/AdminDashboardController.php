<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalSupervisor = User::where('role', 'supervisor')->count();

        $recentUsers = User::select('id', 'name', 'email', 'role', 'created_at')
            ->whereIn('role', ['mahasiswa', 'supervisor'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        $currentDate = Carbon::createFromDate($year, $month, 1);

        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        $monthName = $currentDate->translatedFormat('F');
        $daysInMonth = $currentDate->daysInMonth;
        $startOffset = $startOfMonth->dayOfWeekIso - 1;

        $today = Carbon::now();
        $todayDay = ($today->month == $month && $today->year == $year)
            ? $today->day
            : null;

        $prevDate = $currentDate->copy()->subMonth();
        $nextDate = $currentDate->copy()->addMonth();

        $prevMonth = $prevDate->month;
        $prevYear = $prevDate->year;

        $nextMonth = $nextDate->month;
        $nextYear = $nextDate->year;

        $createdDays = [];

        $createdInMonth = User::select(DB::raw('DATE(created_at) as tgl'))
            ->whereIn('role', ['mahasiswa', 'supervisor'])
            ->whereBetween(DB::raw('DATE(created_at)'), [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString()
            ])
            ->get();

        foreach ($createdInMonth as $r) {
            if (empty($r->tgl)) continue;
            $day = Carbon::parse($r->tgl)->day;
            $createdDays[$day] = true;
        }

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalSupervisor',
            'recentUsers',
            'createdDays',
            'monthName',
            'year',
            'month',
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