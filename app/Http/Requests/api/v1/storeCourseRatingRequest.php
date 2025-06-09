<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class storeCourseRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->user()?->isAdmin())
            return true;

        return $this->user()->id == $this->user_id;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required','exists:courses,id'],
            'user_id'   => [
                'required','exists:users,id',
                Rule::unique('course_ratings')
                    ->where(fn($q)=> $q->where('course_id', $this->course_id))
            ],
            'rating'    => ['required','integer','between:1,5'],
        ];
    }
}
