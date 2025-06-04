<?php

use App\HTTP\Controllers\api\V1\courseController;
use App\HTTP\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('courses/create', [courseController::class, 'store']);
    Route::get('courses', [courseController::class, 'index']);
    Route::get('courses/{id}', [courseController::class, 'show']);
    Route::put('courses/{id}', [courseController::class, 'update']);
    Route::delete('courses/{id}', [courseController::class, 'destroy']);
});
