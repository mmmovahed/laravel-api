<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\updateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
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
}

