<?php

use App\Http\Controllers\api\v1\courseController;
use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\collegeController;
use \App\Http\Controllers\api\v1\categoryController;
use \App\Http\Controllers\api\v1\filtersForCourses;
use \App\Http\Controllers\api\v1\enrollmentController;
use \App\Http\Controllers\api\v1\courseRatingController;
use \App\Http\Controllers\api\v1\sectionResourceController;
use \App\Http\Controllers\api\v1\courseCommentController;


Route::middleware('auth:sanctum')->group(function () {
    //courses API
    Route::prefix('/courses')->group(function(){
        Route::post('/create', [courseController::class, 'store']);
        Route::get('/', [courseController::class, 'index']);
        Route::get('/{id}', [courseController::class, 'show']);
        Route::put('/{id}', [courseController::class, 'update']);
        Route::delete('/{id}', [courseController::class, 'destroy']);
        Route::get('/search', [courseController::class, 'search']);
    });


    //colleges API
    Route::apiResource('colleges', collegeController::class);

    //Categories API
    Route::apiResource('categories', categoryController::class);

    //Filters
    Route::get('filters/mostwanted', [filtersForCourses::class, 'mostWanted']);
    Route::get('filters/ratedcourses', [filtersForCourses::class, 'ratedCourses']);
    Route::get('filters/newlyaddedcourses', [filtersForCourses::class, 'newlyAddedCourses']);

    // Enrollments
    Route::get('enrollments', [enrollmentController::class,'index']);
    Route::post('enrollments', [enrollmentController::class,'store']);
    Route::delete('enrollments/{id}', [enrollmentController::class,'destroy']);

    // Ratings
    Route::apiResource('ratings', courseRatingController::class)->except(['create','edit', 'index']);

    // Course Resources
    Route::prefix('resources')->group(function () {
        Route::get('/course/{courseId}', [sectionResourceController::class, 'index']);
        Route::post('/', [sectionResourceController::class, 'store']);
        Route::get('/{resource}', [sectionResourceController::class, 'show']);
        Route::put('/{resource}', [sectionResourceController::class, 'update']);
        Route::delete('/{resource}', [sectionResourceController::class, 'destroy']);
        Route::get('/{resource}/download', [sectionResourceController::class, 'download']);

    });

    // My course
    Route::get('/my-courses', [courseController::class, 'myCourses']);

    // Comments
    Route::prefix('comments')->group(function () {
        Route::post('/', [courseCommentController::class, 'store']);
        Route::get('/{course_id}', [courseCommentController::class, 'index']);
        Route::delete('/{Comment_id}', [courseCommentController::class, 'destroy']);
    });
});


//Route::middleware('auth:sanctum')->get('test', function () {
//    return ['data' => 'You are logged in!'];
//});
