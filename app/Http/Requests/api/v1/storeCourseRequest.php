<?php

namespace app\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class storeCourseRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'college_id' => 'required|exists:colleges,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher' => 'sometimes|string|max:255',
            'status' => 'required|in:active,inactive',
            'thumbnail_path' => 'sometimes|image',
        ];
    }
}
