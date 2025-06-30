<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRating;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\storeCourseRequest;
use App\Http\Requests\api\v1\updateCourseRequest;
use App\Http\Requests\api\v1\massDestroyCourseRequest;
use App\Traits\ApiResponses;

class CourseController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $courses = Course::with(['category', 'college'])->get();
        return $this->ok("Course list fetched successfully.", $courses);
    }

    public function show(Request $request, Course $course, $courseId)
    {
        $user = $request->user();

        $isRegistered = $course->users()->where('user_id', $user->id)->exists();

        $course = Course::with(['college', 'category'])->findOrFail($courseId);

        $userRating = CourseRating::where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

        return $this->ok('Course details.', [
            'course' => $course,
            'is_registered' => $isRegistered,
            'user_rating' => $userRating?->rating ?? null,
        ]);
    }

    public function store(storeCourseRequest $request)
    {
        $course = Course::create($request->validated());

        return $this->ok("Course created successfully.", $course);
    }

    public function update(updateCourseRequest $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return $this->error("Course not found.", 404);
        }

        if (!$request->user()->isAdmin()) {
            return $this->error("Unauthorized.", 403);
        }

        $course->update($request->validated());

        return $this->ok("Course updated successfully.", $course);
    }

    public function destroy(massDestroyCourseRequest $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return $this->error("Course not found.", 404);
        }

        if (!$request->user()->isAdmin()) {
            return $this->error("Unauthorized.", 403);
        }

        $course->delete();

        return $this->ok("Course deleted successfully.");
    }

    public function myCourses(Request $request)
    {
        $user = $request->user();

        $courses = $user->courses()->with('college', 'category')->get();

        return $this->ok('Registered courses fetched.', $courses);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        if (!$keyword)
            return $this->error('No search keyword provided', 422);

        $courses = Course::query()
            ->where('name', 'like', "%{keyword}%")
            ->orwhere('teacher', 'like', "%{keyword}%")
            ->with('college', 'category')
            ->get();

        return $this->ok('Search results.', $courses);
    }
}
