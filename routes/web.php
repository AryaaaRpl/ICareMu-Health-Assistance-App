<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\JadwalSkriningController;
use App\Http\Controllers\StartupPitchController;
use App\Http\Controllers\DashboardSiswaController;
use App\Http\Controllers\DashboardUksController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\MenstrualHealthController;
use App\Http\Controllers\InventarisUksController;
use App\Http\Controllers\AiAssistantController;

// Startup Pitch Route
Route::get('/', [StartupPitchController::class, 'index'])->name('pitch');
Route::get('/pitch', [StartupPitchController::class, 'index']);

// App Authentication Flow Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterStep1'])->name('register.step1');
Route::post('/register', [AuthController::class, 'processRegisterStep1'])->name('register.step1.post');

Route::get('/register/payment', [AuthController::class, 'showRegisterStep2'])->name('register.step2');
Route::post('/register/payment', [AuthController::class, 'processRegisterStep2'])->name('register.step2.post');

Route::get('/register/profile', [AuthController::class, 'showRegisterStep3'])->name('register.step3');
Route::post('/register/profile', [AuthController::class, 'processRegisterStep3'])->name('register.step3.post');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::prefix('app')->group(function () {
        Route::get('/dashboard-siswa', [DashboardSiswaController::class, 'index'])->name('dashboard.siswa');
        Route::get('/dashboard-uks', [DashboardUksController::class, 'index'])->name('dashboard.uks');

        Route::get('/health-record', [RekamMedisController::class, 'index'])->name('health.record');
        Route::post('/health-record', [RekamMedisController::class, 'store'])->name('health.record.store');

        Route::get('/menstrual-health', [MenstrualHealthController::class, 'index'])->name('menstrual.health');
        Route::post('/menstrual-health', [MenstrualHealthController::class, 'store'])->name('menstrual.health.store');

        Route::get('/uks-inventory', [InventarisUksController::class, 'index'])->name('uks.inventory');
        Route::post('/uks-inventory', [InventarisUksController::class, 'store'])->name('uks.inventory.store');
        Route::put('/uks-inventory/{inventory}', [InventarisUksController::class, 'update'])->name('uks.inventory.update');
        Route::delete('/uks-inventory/{inventory}', [InventarisUksController::class, 'destroy'])->name('uks.inventory.destroy');

        Route::get('/ai-assistant', [AiAssistantController::class, 'showAiAssistant'])->name('ai.assistant');
        Route::post('/ai-assistant/ask', [AiAssistantController::class, 'ask'])->name('ai.assistant.ask');

        Route::get('/edukasi-ismuba', [AiAssistantController::class, 'showEdukasiIsmuba'])->name('edukasi.ismuba');
    });

    Route::resource('jadwal-skrining', JadwalSkriningController::class)->names('jadwal_skrining');
    Route::get('/school-screening', [JadwalSkriningController::class, 'index'])->name('school.screening');
});
