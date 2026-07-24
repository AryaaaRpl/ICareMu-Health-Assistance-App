<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AiAssistantController;
use App\Http\Controllers\Web\EdukasiIsmubaController;
use App\Http\Controllers\Web\InventarisUksWebController;
use App\Http\Controllers\Web\MenstrualHealthController;
use App\Http\Controllers\Web\RekamMedisWebController;
use App\Http\Controllers\Web\SkriningWebController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Shared Student & Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin / Petugas UKS Protected Routes
    Route::middleware('role:admin_uks,super_admin,petugas_uks,admin_super')->group(function () {
        Route::get('/dashboard-uks', [DashboardController::class, 'index'])->name('dashboard.uks');
        Route::get('/dashboard/export', [DashboardController::class, 'exportLaporan'])->name('dashboard.export');

        // Smart Health Record (Rekam Medis)
        Route::get('/rekam-medis', [RekamMedisWebController::class, 'index'])->name('rekam-medis.index');
        Route::post('/rekam-medis', [RekamMedisWebController::class, 'store'])->name('rekam-medis.store');

        // Skrining Kesehatan Admin
        Route::get('/skrining', [SkriningWebController::class, 'index'])->name('skrining.index');
        Route::post('/skrining/jadwal', [SkriningWebController::class, 'storeJadwal'])->name('skrining.jadwal.store');
        Route::post('/skrining/peserta', [SkriningWebController::class, 'storePeserta'])->name('skrining.peserta.store');

        // Inventaris UKS
        Route::get('/inventaris', [InventarisUksWebController::class, 'index'])->name('inventaris.index');
        Route::post('/inventaris', [InventarisUksWebController::class, 'store'])->name('inventaris.store');
    });

    // Student & AI Assistant & Edukasi Routes
    Route::middleware('role:siswa,admin_uks,super_admin,petugas_uks')->group(function () {
        // Skrining Mandiri Siswa
        Route::get('/skrining-harian', [SkriningWebController::class, 'createSiswa'])->name('skrining.siswa');
        Route::post('/skrining-harian', [SkriningWebController::class, 'storeSiswa'])->name('skrining.siswa.store');

        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/analyze', [AiAssistantController::class, 'analyze'])->name('ai.analyze');
        Route::post('/ai/chat', [AiAssistantController::class, 'chat'])->name('ai.chat');

        Route::get('/ismuba', [EdukasiIsmubaController::class, 'index'])->name('ismuba.index');
        Route::get('/ismuba/{article:slug}', [EdukasiIsmubaController::class, 'show'])->name('ismuba.show');
    });

    // Strict Female Students Only Routes (Menstrual Health)
    Route::middleware('female_student')->group(function () {
        Route::get('/menstrual-health', [MenstrualHealthController::class, 'index'])->name('menstrual.index');
        Route::post('/menstrual-health', [MenstrualHealthController::class, 'store'])->name('menstrual.store');
    });
});

require __DIR__.'/auth.php';
