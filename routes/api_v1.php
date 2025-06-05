<?php

use App\Http\Controllers\api\v1\courseController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\collegeController;
use \App\Http\Controllers\api\v1\categoryController;

Route::middleware('auth:sanctum')->group(function () {
    //courses API
    Route::post('courses/create', [courseController::class, 'store']);
    Route::get('courses', [courseController::class, 'index']);
    Route::get('courses/{id}', [courseController::class, 'show']);
    Route::put('courses/{id}', [courseController::class, 'update']);
    Route::delete('courses/{id}', [courseController::class, 'destroy']);

    //colleges API
    Route::apiResource('colleges', collegeController::class);

    //Categories API
    Route::apiResource('categories', categoryController::class);
});
