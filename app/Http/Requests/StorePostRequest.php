<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            'text' => ['string']
        ];
    }
}
