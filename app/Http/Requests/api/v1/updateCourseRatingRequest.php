<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class updateCourseRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()?->isAdmin())
            return true;

        return $this->user()->id == $this->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'course_id' => 'sometimes|exist:courses,id',
//            'user_id' => 'sometimes|exist:users,id|',
            'rating' => 'sometimes|between:1,5',
        ];
    }
}
