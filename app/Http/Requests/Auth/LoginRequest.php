<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }


    public function rules(): array
    {
        return [
            'username' => ['required_without:email', 'string'],
            'email' => ['required_without:username', 'email', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
