<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'max:255', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            'text' => ['string']
        ];

        return $this->method() === 'PUT' ? $rules : array_map(fn(array $rule) => ['sometimes', ...$rule], $rules);
    }
}
