<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

// Route de test
Route::get('/test', function () {
    return response()->json([
        'message' => 'API RetrouveMoi fonctionne !'
    ]);
});

// Routes API des catégories
Route::apiResource('categories', CategoryController::class);