<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\InventarisUksWebController;
use App\Http\Controllers\Web\RekamMedisWebController;
use App\Http\Controllers\Web\SkriningWebController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard-uks', [DashboardController::class, 'index'])->name('dashboard.uks');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Smart Health Record (Rekam Medis)
    Route::get('/rekam-medis', [RekamMedisWebController::class, 'index'])->name('rekam-medis.index');
    Route::post('/rekam-medis', [RekamMedisWebController::class, 'store'])->name('rekam-medis.store');

    // Skrining Kesehatan
    Route::get('/skrining', [SkriningWebController::class, 'index'])->name('skrining.index');
    Route::post('/skrining/jadwal', [SkriningWebController::class, 'storeJadwal'])->name('skrining.jadwal.store');
    Route::post('/skrining/peserta', [SkriningWebController::class, 'storePeserta'])->name('skrining.peserta.store');

    // Inventaris UKS
    Route::get('/inventaris', [InventarisUksWebController::class, 'index'])->name('inventaris.index');
    Route::post('/inventaris', [InventarisUksWebController::class, 'store'])->name('inventaris.store');
});

require __DIR__.'/auth.php';
