<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\updateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\SectionResource;
use App\Models\CourseRating;
use App\Models\CourseComment;
use App\Traits\ApiResponses;

class UserController extends Controller
{
    use ApiResponses;

    public function index(Request $request)
    {
        if ($request->user()->role == "admin") {
            $users = User::select('id', 'name', 'email', 'role', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->ok('User list fetched.', $users);
        }
        else{
            return $this->error("Unauthenticated", 403 );
        }
    }

    public function userCourses(Request $request, $id)
    {
        if ($request->user()->role == "admin") {
            $user = User::with(['courses.category', 'courses.college'])->findOrFail($id);

            $courses = $user->courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'teacher' => $course->teacher,
                    'status' => $course->status,
                    'category' => [
                        'id' => $course->category->id,
                        'name' => $course->category->name,
                    ],
                    'college' => [
                        'id' => $course->college->id,
                        'name' => $course->college->name,
                    ],
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at,
                ];
            });

            return $this->ok("Courses for user: {$user->name}", $courses);
        }
        else{
            return $this->error("Unauthenticated", 403 );
        }
    }

    public function update(updateUserRequest $request, $id)
    {
        if (!$request->user()->role == "admin")
            return $this->error("Unauthenticated", 403 );


        $user = User::find($id);


        $user->update($request->validated());

        return $this->ok("User updated successfully.", $user);
    }

    public function statistics(Request $request)
    {
        if (!($request->user()->role == "admin"))
            return $this->error('Unauthenticated', 403);

        $topCourse = Course::withCount('users')
            ->orderByDesc('users_count')
            ->first();

        $topRatedCourse = Course::withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->first();

        $topUser = User::withCount('courses')
            ->orderByDesc('courses_count')
            ->first();

        return $this->ok('Admin stats fetched.', [
            'total_users' => User::count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_courses' => Course::count(),
            'active_courses' => Course::where('status', 'active')->count(),
            'total_resources' => SectionResource::count(),
            'total_comments' => CourseComment::count(),
            'total_ratings' => CourseRating::count(),
            'average_rating' => round(CourseRating::avg('rating'), 2),

            'most_popular_course' => $topCourse ? [
                'id' => $topCourse->id,
                'name' => $topCourse->name,
                'users_count' => $topCourse->users_count,
            ] : null,

            'top_rated_course' => $topRatedCourse ? [
                'id' => $topRatedCourse->id,
                'name' => $topRatedCourse->name,
                'avg_rating' => round($topRatedCourse->ratings_avg_rating, 2),
            ] : null,

            'most_active_user' => $topUser ? [
                'id' => $topUser->id,
                'name' => $topUser->name,
                'courses_count' => $topUser->courses_count,
            ] : null,
        ]);
    }
}

