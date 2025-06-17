<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionResource extends Model
{
    protected $fillable=['course_id', 'title', 'type', 'file', 'file_path'];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
