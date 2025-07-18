<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class updateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && ($user->isAdmin() || $user->isTeacher());
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
            'thumbnail_path' => 'sometimes|image',
            'status' => 'sometimes|in:active,inactive',
        ];
    }
}
