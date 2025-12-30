<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ObatAPIController;
use App\Http\Controllers\API\PesananAPIController;

// API Routes with versioning
Route::prefix('v1')->group(function () {
    // Obat API
    Route::get('/obat', [ObatAPIController::class, 'index']);
    Route::get('/obat/{id}', [ObatAPIController::class, 'show']);
    Route::get('/obat/stock/{kode}', [ObatAPIController::class, 'checkStock']);
    Route::get('/obat/stock/low', [ObatAPIController::class, 'stockLow']);

    // Pesanan API
    Route::get('/pesanan', [PesananAPIController::class, 'index']);
    Route::post('/pesanan', [PesananAPIController::class, 'store']);
    Route::get('/pesanan/{id}', [PesananAPIController::class, 'show']);
});

// Fallback API route
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found'
    ], 404);
});
