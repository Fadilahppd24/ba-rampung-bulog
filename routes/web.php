<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BaRampungController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MitraPengolahanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PimpinanCabangController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

// ---- Guest ----
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

// ---- Authenticated ----
// Admin Gudang, Admin Kantor, dan Pimpinan Cabang
Route::middleware(['auth', 'role:admin_gudang,admin_kantor,pimpinan_cabang'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---- BA Rampung ----
    Route::get('/ba-rampung', [BaRampungController::class, 'index'])
        ->name('ba-rampung.index');

    Route::get('/ba-rampung-export', [BaRampungController::class, 'export'])
        ->name('ba-rampung.export');

    Route::get('/ba-rampung/{baRampung}', [BaRampungController::class, 'show'])
        ->name('ba-rampung.show');

    Route::get('/ba-rampung/{baRampung}/pdf', [BaRampungController::class, 'pdf'])
        ->name('ba-rampung.pdf');

    // Admin Gudang & Admin Kantor dapat membuat/edit/hapus BA
    Route::middleware('role:admin_gudang,admin_kantor')->group(function () {
        Route::get('/ba-rampung-create', [BaRampungController::class, 'create'])
            ->name('ba-rampung.create');

        Route::post('/ba-rampung', [BaRampungController::class, 'store'])
            ->name('ba-rampung.store');

        Route::get('/ba-rampung/{baRampung}/edit', [BaRampungController::class, 'edit'])
            ->name('ba-rampung.edit');

        Route::put('/ba-rampung/{baRampung}', [BaRampungController::class, 'update'])
            ->name('ba-rampung.update');

        Route::delete('/ba-rampung/{baRampung}', [BaRampungController::class, 'destroy'])
            ->name('ba-rampung.destroy');
    });

    // Admin Kantor melakukan verifikasi BA
    Route::middleware('role:admin_kantor')->group(function () {
        Route::post('/ba-rampung/{baRampung}/verify', [BaRampungController::class, 'verify'])
            ->name('ba-rampung.verify');
    });

    // ---- Gudang ----
    // Semua role dapat melihat data gudang.
    Route::get('/gudang', [GudangController::class, 'index'])
        ->name('gudang.index');

    Route::get('/gudang/{gudang}', [GudangController::class, 'show'])
        ->name('gudang.show');

    // Hanya Admin Kantor yang mengelola master Gudang.
    Route::middleware('role:admin_kantor')->group(function () {
        Route::get('/gudang-create', [GudangController::class, 'create'])
            ->name('gudang.create');

        Route::post('/gudang', [GudangController::class, 'store'])
            ->name('gudang.store');

        Route::get('/gudang/{gudang}/edit', [GudangController::class, 'edit'])
            ->name('gudang.edit');

        Route::put('/gudang/{gudang}', [GudangController::class, 'update'])
            ->name('gudang.update');

        Route::patch('/gudang/{gudang}/toggle-status', [GudangController::class, 'toggleStatus'])
            ->name('gudang.toggle-status');
    });

    // ---- Mitra Pengolahan ----
    Route::get('/mitra', [MitraPengolahanController::class, 'index'])
        ->name('mitra.index');

    Route::get('/mitra/{mitra}', [MitraPengolahanController::class, 'show'])
        ->name('mitra.show');

    // Hanya Admin Kantor yang mengelola master Mitra.
    Route::middleware('role:admin_kantor')->group(function () {
        Route::get('/mitra-create', [MitraPengolahanController::class, 'create'])
            ->name('mitra.create');

        Route::post('/mitra', [MitraPengolahanController::class, 'store'])
            ->name('mitra.store');

        Route::get('/mitra/{mitra}/edit', [MitraPengolahanController::class, 'edit'])
            ->name('mitra.edit');

        Route::put('/mitra/{mitra}', [MitraPengolahanController::class, 'update'])
            ->name('mitra.update');

        Route::patch('/mitra/{mitra}/toggle-status', [MitraPengolahanController::class, 'toggleStatus'])
            ->name('mitra.toggle-status');
    });

    // ---- Pegawai ----
    Route::get('/pegawai', [PegawaiController::class, 'index'])
        ->name('pegawai.index');

    Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])
        ->name('pegawai.show');

    // Hanya Admin Kantor yang mengelola Pegawai.
    Route::middleware('role:admin_kantor')->group(function () {
        Route::get('/pegawai-create', [PegawaiController::class, 'create'])
            ->name('pegawai.create');

        Route::post('/pegawai', [PegawaiController::class, 'store'])
            ->name('pegawai.store');

        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])
            ->name('pegawai.edit');

        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])
            ->name('pegawai.update');

        Route::patch('/pegawai/{pegawai}/toggle-status', [PegawaiController::class, 'toggleStatus'])
            ->name('pegawai.toggle-status');
    });

    // ---- Pimpinan Cabang ----
    // Semua role dapat melihat data pimpinan.
    Route::get('/pimpinan', [PimpinanCabangController::class, 'index'])
        ->name('pimpinan.index');

    Route::get('/pimpinan/{pimpinan}', [PimpinanCabangController::class, 'show'])
        ->name('pimpinan.show');

    // Hanya Admin Kantor yang mengelola data pimpinan.
    Route::middleware('role:admin_kantor')->group(function () {
        Route::get('/pimpinan-create', [PimpinanCabangController::class, 'create'])
            ->name('pimpinan.create');

        Route::post('/pimpinan', [PimpinanCabangController::class, 'store'])
            ->name('pimpinan.store');

        Route::get('/pimpinan/{pimpinan}/edit', [PimpinanCabangController::class, 'edit'])
            ->name('pimpinan.edit');

        Route::put('/pimpinan/{pimpinan}', [PimpinanCabangController::class, 'update'])
            ->name('pimpinan.update');
    });

    // ---- Laporan ----
    // Semua role dapat melihat dan export laporan.
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan-export-excel', [LaporanController::class, 'exportExcel'])
        ->name('laporan.export-excel');

    Route::get('/laporan-export-pdf', [LaporanController::class, 'exportPdf'])
        ->name('laporan.export-pdf');

    // ---- Pengaturan ----
    // Hanya Admin Kantor.
    Route::middleware('role:admin_kantor')->group(function () {
        Route::get('/pengaturan', fn () => redirect()->route('pengaturan.umum'))
            ->name('pengaturan.index');

        Route::get('/pengaturan/umum', [PengaturanController::class, 'umum'])
            ->name('pengaturan.umum');

        Route::post('/pengaturan/umum', [PengaturanController::class, 'updateUmum'])
            ->name('pengaturan.umum.update');

        Route::get('/pengaturan/sistem', [PengaturanController::class, 'sistem'])
            ->name('pengaturan.sistem');

        Route::post('/pengaturan/sistem', [PengaturanController::class, 'updateSistem'])
            ->name('pengaturan.sistem.update');

        Route::get('/pengaturan/backup', [PengaturanController::class, 'backup'])
            ->name('pengaturan.backup');

        Route::get('/pengaturan/backup/download', [PengaturanController::class, 'downloadBackup'])
            ->name('pengaturan.backup.download');

        Route::post('/pengaturan/restore', [PengaturanController::class, 'restore'])
            ->name('pengaturan.restore');

        Route::get('/pengaturan/log-aktivitas', [PengaturanController::class, 'logAktivitas'])
            ->name('pengaturan.log-aktivitas');
    });
});