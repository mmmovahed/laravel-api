<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class storeEnrollmentRequest extends FormRequest
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
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where('status', 'active')
            ],
        ];
    }
}
