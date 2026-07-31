<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;

// Route de test
Route::get('/test', function () {
    return response()->json([
        'message' => 'API RetrouveMoi fonctionne !'
    ]);
});

// Routes API des catégories
Route::apiResource('categories', CategoryController::class);

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('items', ItemController::class);
});