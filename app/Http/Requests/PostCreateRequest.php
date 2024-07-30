<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
            'title' => 'required|max:255',
            'body' => 'required|min:10',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Post title is require.',
            'title.max' => 'Maximum allow 255 character.',
            'body.required' => 'Post body is require.',
            'body.min' => 'Post body must have at least 10 character.',
        ];
    }
}
