<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{

    protected $fillable = [
        'course_id',
        'user_id',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getCourseNameAttribute()
    {
        return $this->course ? $this->course->name : null;
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }
}
