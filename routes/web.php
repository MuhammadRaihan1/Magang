<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\SupervisorController;

// MAHASISWA
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\KegiatanController;
use App\Http\Controllers\Mahasiswa\EvaluasiController as MahasiswaEvaluasiController;

// SUPERVISOR
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\MahasiswaController as SupervisorMahasiswaController;
use App\Http\Controllers\Supervisor\EvaluasiController as SupervisorEvaluasiController;
use App\Http\Controllers\Supervisor\KegiatanController as SupervisorKegiatanController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

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

        // Mahasiswa
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/{user}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{user}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/{user}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

        // Supervisor
        Route::get('/supervisor', [SupervisorController::class, 'index'])->name('supervisor.index');
        Route::get('/supervisor/create', [SupervisorController::class, 'create'])->name('supervisor.create');
        Route::post('/supervisor', [SupervisorController::class, 'store'])->name('supervisor.store');
        Route::get('/supervisor/{user}/edit', [SupervisorController::class, 'edit'])->name('supervisor.edit');
        Route::put('/supervisor/{user}', [SupervisorController::class, 'update'])->name('supervisor.update');
        Route::delete('/supervisor/{user}', [SupervisorController::class, 'destroy'])->name('supervisor.destroy');
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

        // Laporan Kegiatan
        Route::get('/laporan-kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/laporan-kegiatan/tambah', [KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/laporan-kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/laporan-kegiatan/{kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');
        Route::get('/laporan-kegiatan-cetak', [KegiatanController::class, 'print'])->name('kegiatan.print');

        // Hasil Evaluasi (Mahasiswa)
        Route::get('/evaluasi', [MahasiswaEvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('/evaluasi/{evaluasi}', [MahasiswaEvaluasiController::class, 'show'])->name('evaluasi.show');
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

        // Mahasiswa bimbingan
        Route::get('/mahasiswa', [SupervisorMahasiswaController::class, 'index'])->name('mahasiswa.index');

        // Laporan kegiatan mahasiswa (pending/riwayat + detail + approve/reject)
        Route::get('/kegiatan', [SupervisorKegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/kegiatan/{kegiatan}', [SupervisorKegiatanController::class, 'show'])->name('kegiatan.show');
        Route::patch('/kegiatan/{kegiatan}/approve', [SupervisorKegiatanController::class, 'approve'])->name('kegiatan.approve');
        Route::patch('/kegiatan/{kegiatan}/reject', [SupervisorKegiatanController::class, 'reject'])->name('kegiatan.reject');

        // Evaluasi
        Route::get('/evaluasi', [SupervisorEvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('/evaluasi/{mahasiswa}', [SupervisorEvaluasiController::class, 'create'])->name('evaluasi.create');
        Route::post('/evaluasi/{mahasiswa}', [SupervisorEvaluasiController::class, 'store'])->name('evaluasi.store');
    });
