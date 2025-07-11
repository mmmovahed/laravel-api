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

        $user = $request->user();
        if ($user) {
            $query->where('user_id', $user->id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

//        $enrollments = $query->with('course')->get();
//        $enrollments = $query->with('user')->get();

        $enrollments = $query->with(['course', 'user'])->get();

        return $this->ok("Enrollments fetched.", $enrollments);
    }

    public function store(storeEnrollmentRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        $alreadyEnrolled = CourseUser::where('course_id', $data['course_id'])
            ->where('user_id', $data['user_id'])
            ->exists();

        if ($alreadyEnrolled) {
            return $this->error("User is already enrolled in this course.", 409);
        }

        if (CourseUser::create($data)) {
            return $this->ok("User enrolled in course.", $data);
        }

        return $this->error("User did not enroll in course.");
    }

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
