<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\SupervisorController as AdminSupervisorController;

// MAHASISWA
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\KegiatanController as MahasiswaKegiatanController;
use App\Http\Controllers\Mahasiswa\EvaluasiController as MahasiswaEvaluasiController;
use App\Http\Controllers\Mahasiswa\PenilaianController as MahasiswaPenilaianController;

// SUPERVISOR
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\MahasiswaController as SupervisorMahasiswaController;
use App\Http\Controllers\Supervisor\KegiatanController as SupervisorKegiatanController;
use App\Http\Controllers\Supervisor\EvaluasiController as SupervisorEvaluasiController;
use App\Http\Controllers\Supervisor\PenilaianController as SupervisorPenilaianController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('home'))->name('home');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| DASHBOARD UMUM (SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'supervisor' => redirect()->route('supervisor.dashboard'),
        'mahasiswa'  => redirect()->route('mahasiswa.dashboard'),
        default      => redirect()->route('home'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN (ROLE: ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', function () {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/login');
        })->name('logout');

        // Mahasiswa (Admin)
        Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/create', [AdminMahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa', [AdminMahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/{user}/edit', [AdminMahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{user}', [AdminMahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/{user}', [AdminMahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

        // Supervisor (Admin)
        Route::get('/supervisor', [AdminSupervisorController::class, 'index'])->name('supervisor.index');
        Route::get('/supervisor/create', [AdminSupervisorController::class, 'create'])->name('supervisor.create');
        Route::post('/supervisor', [AdminSupervisorController::class, 'store'])->name('supervisor.store');
        Route::get('/supervisor/{user}/edit', [AdminSupervisorController::class, 'edit'])->name('supervisor.edit');
        Route::put('/supervisor/{user}', [AdminSupervisorController::class, 'update'])->name('supervisor.update');
        Route::delete('/supervisor/{user}', [AdminSupervisorController::class, 'destroy'])->name('supervisor.destroy');
    });

/*
|--------------------------------------------------------------------------
| MAHASISWA (ROLE: MAHASISWA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');

        // Laporan Kegiatan (Mahasiswa)
        Route::get('/laporan-kegiatan', [MahasiswaKegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/laporan-kegiatan/tambah', [MahasiswaKegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/laporan-kegiatan', [MahasiswaKegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/laporan-kegiatan/{kegiatan}', [MahasiswaKegiatanController::class, 'show'])->name('kegiatan.show');
        Route::get('/laporan-kegiatan-cetak', [MahasiswaKegiatanController::class, 'print'])->name('kegiatan.print');

        // Hasil Evaluasi (Mahasiswa)
        Route::get('/evaluasi', [MahasiswaEvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('/evaluasi/{evaluasi}', [MahasiswaEvaluasiController::class, 'show'])->name('evaluasi.show');

        // Hasil Penilaian (Mahasiswa)
        Route::get('/penilaian', [MahasiswaPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{penilaian}', [MahasiswaPenilaianController::class, 'show'])->name('penilaian.show');
    });

/*
|--------------------------------------------------------------------------
| SUPERVISOR (ROLE: SUPERVISOR)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {

        Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');

        // Mahasiswa bimbingan (Supervisor)
        Route::get('/mahasiswa', [SupervisorMahasiswaController::class, 'index'])->name('mahasiswa.index');

        // Kegiatan Mahasiswa (Supervisor)
        Route::get('/kegiatan', [SupervisorKegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/kegiatan/{kegiatan}', [SupervisorKegiatanController::class, 'show'])->name('kegiatan.show');
        Route::patch('/kegiatan/{kegiatan}/approve', [SupervisorKegiatanController::class, 'approve'])->name('kegiatan.approve');
        Route::patch('/kegiatan/{kegiatan}/reject', [SupervisorKegiatanController::class, 'reject'])->name('kegiatan.reject');

        // Evaluasi (Supervisor)
        Route::get('/evaluasi', [SupervisorEvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('/evaluasi/{mahasiswa}', [SupervisorEvaluasiController::class, 'create'])->name('evaluasi.create');
        Route::post('/evaluasi/{mahasiswa}', [SupervisorEvaluasiController::class, 'store'])->name('evaluasi.store');

        // Penilaian (Supervisor)
        Route::get('/penilaian', [SupervisorPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{mahasiswa}/create', [SupervisorPenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('/penilaian/{mahasiswa}', [SupervisorPenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('/penilaian/{mahasiswa}', [SupervisorPenilaianController::class, 'show'])->name('penilaian.show');

        // ✅ EDIT + UPDATE Penilaian (Supervisor)
        Route::get('/penilaian/{mahasiswa}/edit', [SupervisorPenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::put('/penilaian/{mahasiswa}', [SupervisorPenilaianController::class, 'update'])->name('penilaian.update');
    });
