<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transactions/{id}/upload-proof', [TransactionController::class, 'uploadProof']);
Route::post('/transactions/{id}/approve', [TransactionController::class, 'approveTransaction']);
