<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'max:255', 'min:3', 'unique:users,username', 'regex:/^[a-zA-Z0-9_.-]+$/', 'string'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'string'],
            'first_name' => ['required', 'max:255', 'min:3', 'string'],
            'last_name' => ['required', 'max:255', 'min:3', 'string'],
            'password' => ['required', 'min:8', 'string', 'confirmed'],
        ];
    }

}
