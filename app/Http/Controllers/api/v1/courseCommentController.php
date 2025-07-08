<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Models\CourseComment;
use App\Http\Requests\api\v1\storeCourseCommentRequest;

class courseCommentController extends Controller
{
    use ApiResponses;

    public function store(storeCourseCommentRequest $request)
    {
        $comment = CourseComment::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user()->id,
            'comment' => $request->comment,
        ]);

        return $this->ok('Comment added.', $comment);
    }

    public function index($course_id)
    {
        $comments = CourseComment::with('user:id,name')
        ->where('course_id', $course_id)
        ->latest()
        ->get();

        return $this->ok('Comments fetched.', $comments);
    }

    public function destroy($id, Request $request)
    {
        $comment = CourseComment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id && !$request->user()){
            return $this->error('Not authorized', 403);
        }
        $comment->delete();

        return $this->ok('Comment deleted.');
    }
}
