<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\JadwalSkriningController;

use App\Http\Controllers\StartupPitchController;

// Startup Pitch Route
Route::get('/', [StartupPitchController::class, 'index'])->name('pitch');
Route::get('/pitch', [StartupPitchController::class, 'index']);

// App Authentication Flow Routes (Figma Screenshots Body-6, Body-7, Body-9, ICAREMU.png)
Route::view('/login', 'pages.auth.login')->name('login');
Route::view('/register', 'pages.auth.register-step1')->name('register.step1');
Route::view('/register/payment', 'pages.auth.register-step2')->name('register.step2');
Route::view('/register/profile', 'pages.auth.register-step3')->name('register.step3');

// Application Module Routes (Figma Screenshots Body, Body-1 through Body-5, Body-8, Body-10)
Route::prefix('app')->group(function () {
    Route::view('/dashboard-siswa', 'pages.dashboard-siswa')->name('dashboard.siswa');
    Route::view('/dashboard-uks', 'pages.dashboard-uks')->name('dashboard.uks');
    Route::view('/health-record', 'pages.health-record')->name('health.record');
    Route::view('/school-screening', 'pages.school-screening')->name('school.screening');
    Route::view('/ai-assistant', 'pages.ai-assistant')->name('ai.assistant');
    Route::view('/edukasi-ismuba', 'pages.edukasi-ismuba')->name('edukasi.ismuba');
    Route::view('/menstrual-health', 'pages.menstrual-health')->name('menstrual.health');
    Route::view('/uks-inventory', 'pages.inventory')->name('uks.inventory');
});

