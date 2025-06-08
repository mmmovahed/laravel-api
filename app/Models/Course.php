<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseRating;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'college_id',
        'name',
        'description',
        'teacher',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

}
