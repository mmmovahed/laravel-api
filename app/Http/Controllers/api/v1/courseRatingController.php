<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\CourseRating;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use App\Http\Requests\api\v1\storeCourseRatingRequest;
use App\Http\Requests\api\v1\updateCourseRatingRequest;

class courseRatingController extends Controller
{
    use ApiResponses;

    public function store(StoreCourseRatingRequest $request)
    {
        $rating = CourseRating::create($request->validated());
        if($rating)
            return $this->ok("Rating added.", $rating);
        else
            abort(403,"Not allowed request");
    }

    public function update(updateCourseRatingRequest $request, CourseRating $rating)
    {
        $rating->update($request->validated());
        return $this->ok("Rate updated.", $rating);
    }

    public function destroy(Request $request, CourseRating $rating)
    {
        if ($request->user()->id != $rating->user_id && !$request->user()->isAdmin()) {
            return $this->error("Unauthorized.",403);
        }
        if($rating->delete())
            return $this->ok("Rate removed.");

        abort(404,"Not found");
    }
}
