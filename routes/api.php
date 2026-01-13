<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResepApiController;

Route::middleware('api')->group(function () {
    // Public routes (no auth required)
    Route::get('/reseps', [ResepApiController::class, 'index']);
    Route::get('/reseps/{id}', [ResepApiController::class, 'show']);
    Route::get('/reseps/{id}/user', [ResepApiController::class, 'showByUser']);

    // Protected routes (auth required)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/reseps', [ResepApiController::class, 'store']);
        Route::put('/reseps/{id}', [ResepApiController::class, 'update']);
        Route::delete('/reseps/{id}', [ResepApiController::class, 'destroy']);
        
        // Favorites
        Route::get('/favorites', [ResepApiController::class, 'favorites']);
        Route::post('/reseps/{id}/favorite', [ResepApiController::class, 'favorite']);
        Route::delete('/reseps/{id}/favorite', [ResepApiController::class, 'unfavorite']);
        
        // User info
        Route::get('/user', function (Request $request) {
            return response()->json($request->user());
        });
    });

    // Search endpoint
    Route::get('/search', [ResepApiController::class, 'search']);
});
