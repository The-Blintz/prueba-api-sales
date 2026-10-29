<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'app' => config('app.name'),
        'env' => app()->environment(),
        'version' => app()->version(),
        'status' => 'ok',
    ]);
});

Route::apiResource('products', ProductController::class);

Route::get('/sales', [SaleController::class, 'index']);
Route::post('/sales', [SaleController::class, 'store']);
Route::get('/sales/{id}', [SaleController::class, 'show']);
Route::delete('/sales/{id}', [SaleController::class, 'destroy']);
