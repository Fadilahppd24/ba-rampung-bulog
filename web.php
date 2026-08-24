<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BaRampungController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

// ---- Guest ----
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

// ---- Authenticated (all active roles) ----
Route::middleware(['auth', 'role:admin_gudang,pimpinan_cabang,admin_sistem'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // BA Rampung — Admin Gudang & Admin Sistem can create/edit/delete,
    // Pimpinan Cabang has read + verify only. Fine-grained checks also
    // happen in BaRampungPolicy on every action.
    Route::get('/ba-rampung', [BaRampungController::class, 'index'])->name('ba-rampung.index');
    Route::get('/ba-rampung-export', [BaRampungController::class, 'export'])->name('ba-rampung.export');
    Route::get('/ba-rampung/{baRampung}', [BaRampungController::class, 'show'])->name('ba-rampung.show');
    Route::get('/ba-rampung/{baRampung}/pdf', [BaRampungController::class, 'pdf'])->name('ba-rampung.pdf');

    Route::middleware('role:admin_gudang,admin_sistem')->group(function () {
        Route::get('/ba-rampung-create', [BaRampungController::class, 'create'])->name('ba-rampung.create');
        Route::post('/ba-rampung', [BaRampungController::class, 'store'])->name('ba-rampung.store');
        Route::get('/ba-rampung/{baRampung}/edit', [BaRampungController::class, 'edit'])->name('ba-rampung.edit');
        Route::put('/ba-rampung/{baRampung}', [BaRampungController::class, 'update'])->name('ba-rampung.update');
        Route::delete('/ba-rampung/{baRampung}', [BaRampungController::class, 'destroy'])->name('ba-rampung.destroy');
    });

    Route::middleware('role:pimpinan_cabang,admin_sistem')->group(function () {
        Route::post('/ba-rampung/{baRampung}/verify', [BaRampungController::class, 'verify'])->name('ba-rampung.verify');
    });
});

// NOTE: Gudang, Mitra Pengolahan, Pegawai, Pimpinan Cabang (full CRUD UI),
// Laporan, and Pengaturan routes are intentionally not included in this
// core phase — see README "Fase Berikutnya".
