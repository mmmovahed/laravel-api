<?php

namespace App\HTTP\Controllers\Api\V1;

use App\HTTP\Controllers\Controller;
use App\Models\Course;
use Illuminate\HTTP\Request;
use App\HTTP\Requests\api\v1\storeCourseRequest;
use App\HTTP\Requests\api\v1\updateCourseRequest;
use App\HTTP\Requests\api\v1\massDestroyCourseRequest;
use App\Traits\ApiResponses;

class CourseController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $courses = Course::with(['category', 'college'])->get();
        return $this->ok("Course list fetched successfully.", $courses);
    }

    public function show($id)
    {
        $course = Course::with(['category', 'college'])->find($id);

        if (!$course) {
            return $this->error("Course not found.", 404);
        }

        return $this->ok("Course details fetched successfully.", $course);
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());

        return $this->ok("Course created successfully.", $course);
    }

    public function update(UpdateCourseRequest $request, $id)
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
}
