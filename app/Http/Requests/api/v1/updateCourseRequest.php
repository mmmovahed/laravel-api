<?php

namespace App\HTTP\Requests\api\v1;

use Illuminate\Foundation\HTTP\FormRequest;

class updateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:categories,id',
            'college_id' => 'sometimes|exists:colleges,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'teacher' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:active,inactive',
        ];
    }
}
