<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {


        $rules = [
            'username' => ['required', 'max:255', 'min:3', 'unique:users,username', 'regex:/^[a-zA-Z0-9_.-]+$/', 'string'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'string'],
            'first_name' => ['required', 'max:255', 'min:3', 'string'],
            'last_name' => ['required', 'max:255', 'min:3', 'string'],
            'old_password' => ['required_with:password', 'current_password', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        return $this->method() === 'PUT' ? $rules : $this->changeRules($rules);


    }

    private function changeRules(array $rules): array
    {
        foreach ($rules as $key => $value) {
            if (!in_array($key, ['old_password'])) {
                $rules[$key] = ['sometimes', ...$value];
            }
        }

        return $rules;
    }


}
