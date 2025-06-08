<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Requests\api\v1\checkForAuth;

class filtersForCourses extends Controller
{
    public function mostWanted(checkForAuth $request)
    {
        return Course::withCount('users')->orderByDesc('users_count')->get();
    }

    public function ratedCourses(checkForAuth $request)
    {
        return Course::withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating')->get();
    }

    public function newlyAddedCourses(checkForAuth $request)
    {
        return Course::orderByDesc('created_at')->get();
    }
}
