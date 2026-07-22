<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\JadwalSkriningController;

use App\Http\Controllers\StartupPitchController;

// Startup Pitch Route
Route::get('/', [StartupPitchController::class, 'index'])->name('pitch');
Route::get('/pitch', [StartupPitchController::class, 'index']);

// App Authentication Flow Routes (Guest only ideally, but we leave as is for now)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::view('/register', 'auth.register-step1')->name('register.step1');
Route::view('/register/payment', 'auth.register-step2')->name('register.step2');
Route::view('/register/profile', 'auth.register-step3')->name('register.step3');

// Protected Routes (Only accessible by authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::prefix('app')->group(function () {
        Route::view('/dashboard-siswa', 'pages.dashboard-siswa')->name('dashboard.siswa');
        Route::view('/dashboard-uks', 'pages.dashboard-uks')->name('dashboard.uks');
        Route::view('/health-record', 'pages.health-record')->name('health.record');
        Route::view('/ai-assistant', 'pages.ai-assistant')->name('ai.assistant');
        Route::view('/edukasi-ismuba', 'pages.edukasi-ismuba')->name('edukasi.ismuba');
        Route::view('/menstrual-health', 'pages.menstrual-health')->name('menstrual.health');
        Route::view('/uks-inventory', 'pages.inventory')->name('uks.inventory');
    });

    Route::resource('jadwal-skrining', JadwalSkriningController::class)->names('jadwal_skrining');
});


