<?php

namespace App\HTTP\Requests\api;

use Illuminate\Foundation\Http\FormRequest;
use function Laravel\Prompts\password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'phone' =>
            [
                'required',
                'string',
                'min:11',
                'max:11',
            ],
            'password' => [
                'required',
                'min:6',
            ],
        ];
    }
}
