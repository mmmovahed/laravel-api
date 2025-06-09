<?php

// app/Models/CourseUser.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';

    protected $fillable = ['user_id', 'course_id'];

    // 🔗 ارتباط با Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCourseNameAttribute()
    {
        return $this->course ? $this->course->name : null; // یا title
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }
}
