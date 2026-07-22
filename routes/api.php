<?php

use App\Http\Controllers\Api\V1\RekamMedisController;
use App\Http\Middleware\ForceJsonResponseMiddleware;
use App\Http\Middleware\TenantResolverMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([ForceJsonResponseMiddleware::class])->prefix('v1')->group(function () {

    // Authenticated API V1 Routes
    Route::middleware(['auth:sanctum', TenantResolverMiddleware::class])->group(function () {
        // Rekam Medis Endpoints
        Route::get('/rekam-medis', [RekamMedisController::class, 'index']);
        Route::post('/rekam-medis', [RekamMedisController::class, 'store']);
        Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show']);
        Route::post('/rekam-medis/{id}/verify', [RekamMedisController::class, 'verify']);
    });
});
