<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
