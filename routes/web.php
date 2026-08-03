<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AiAssistantController;
use App\Http\Controllers\Web\EdukasiIsmubaController;
use App\Http\Controllers\Web\InventarisUksWebController;
use App\Http\Controllers\Web\MenstrualHealthController;
use App\Http\Controllers\Web\RekamMedisWebController;
use App\Http\Controllers\Web\RiwayatKunjunganSiswaController;
use App\Http\Controllers\Web\SkriningWebController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    // Shared Student & Dashboard Route
    Route::get('/activation', [\App\Http\Controllers\PaymentController::class, 'activation'])->name('payment.activation');
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
        Route::get('/rekam-medis/{id}', [RekamMedisWebController::class, 'show'])->name('rekam-medis.show');
        Route::post('/rekam-medis', [RekamMedisWebController::class, 'store'])->name('rekam-medis.store');

        // Skrining Kesehatan Admin & Detail Triage
        Route::get('/skrining', [\App\Http\Controllers\SkriningController::class, 'index'])->name('skrining.index');
        Route::get('/skrining/{skrining}', [\App\Http\Controllers\SkriningController::class, 'show'])->name('skrining.show');
        Route::get('/skrining/{skrining}/tindakan', function ($skrining) {
            return redirect()->route('skrining.show', $skrining);
        });
        Route::put('/skrining/{skrining}/tindakan', [\App\Http\Controllers\SkriningController::class, 'updateTindakan'])->name('skrining.tindakan.update');
        Route::post('/skrining/jadwal', [\App\Http\Controllers\SkriningController::class, 'storeJadwal'])->middleware('throttle:10,1')->name('skrining.jadwal.store');
        Route::post('/skrining/peserta', [\App\Http\Controllers\SkriningController::class, 'storePeserta'])->middleware('throttle:10,1')->name('skrining.peserta.store');

        // Inventaris UKS
        Route::get('/inventaris', [InventarisUksWebController::class, 'index'])->name('inventaris.index');
        Route::post('/inventaris', [InventarisUksWebController::class, 'store'])->name('inventaris.store');
    });

    // Student & AI Assistant & Edukasi Routes
    Route::middleware('role:siswa,admin_uks,super_admin,petugas_uks,guru_ismuba')->group(function () {
        // Skrining Mandiri Siswa
        Route::get('/skrining-harian', function () {
            return view('siswa.skrining');
        })->name('skrining.siswa');
        Route::post('/skrining-harian', [\App\Http\Controllers\SkriningController::class, 'storeStudent'])->middleware('throttle:10,1')->name('skrining.store');

        Route::get('/riwayat-kunjungan', [RiwayatKunjunganSiswaController::class, 'index'])->name('siswa.riwayat');
        // Smart Health Record Siswa
        Route::get('/health-record', [\App\Http\Controllers\HealthRecordController::class, 'index'])->name('health-record.index');

        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/analyze', [AiAssistantController::class, 'analyze'])->middleware('throttle:5,1')->name('ai.analyze');
        Route::post('/ai/chat', [AiAssistantController::class, 'chat'])->middleware('throttle:15,1')->name('ai.chat');
        Route::get('/ai/history', [AiAssistantController::class, 'getHistory'])->name('ai.history');
        Route::post('/api/chat/send', [ChatController::class, 'sendMessage'])->middleware('throttle:20,1')->name('api.chat.send');

        Route::get('/ismuba', [\App\Http\Controllers\IsmubaController::class, 'index'])->name('ismuba.index');
        Route::post('/ismuba', [\App\Http\Controllers\IsmubaController::class, 'store'])->middleware('throttle:10,1')->name('ismuba.store');
        Route::put('/ismuba/{article}', [\App\Http\Controllers\IsmubaController::class, 'update'])->name('ismuba.update');
        Route::delete('/ismuba/{article}', [\App\Http\Controllers\IsmubaController::class, 'destroy'])->name('ismuba.destroy');
        Route::get('/ismuba/{article:slug}', [\App\Http\Controllers\IsmubaController::class, 'show'])->name('ismuba.show');
    });

    // Strict Female Students Only Routes (Menstrual Health)
    Route::middleware('female_student')->group(function () {
        Route::get('/menstrual-health', [MenstrualHealthController::class, 'index'])->name('menstrual.index');
        Route::post('/menstrual-health', [MenstrualHealthController::class, 'store'])->middleware('throttle:10,1')->name('menstrual.store');
        Route::put('/menstrual-health/{record}/finish', [MenstrualHealthController::class, 'finish'])->name('menstrual.finish');
    });
});

require __DIR__.'/auth.php';