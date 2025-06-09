<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\massDestroyEnrollmentRequest;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use App\Http\Requests\api\v1\storeEnrollmentRequest;

class EnrollmentController extends Controller
{
    use ApiResponses;

    public function index(Request $request)
    {
        $query = CourseUser::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $enrollments = $query->with('course')->get();
        $enrollments = $query->with('user')->get();

        return $this->ok("Enrollments fetched.", $enrollments);
    }

    public function store(storeEnrollmentRequest $request)
    {
        if (CourseUser::create($request->validated())) {
            return $this->ok("User enrolled in course.");
        }
        return $this->error("User did not enrol in course.");
    }

    // لغو ثبت‌نام
    public function destroy(massDestroyEnrollmentRequest $request, $id)
    {
        $en = \DB::table('course_user')->where('id',$id)->first();
        if (!$en) {
            return $this->error("Enrollment not found.",404);
        }

        \DB::table('course_user')->where('id',$id)->delete();
        return $this->ok("Enrollment cancelled.");
    }
}
