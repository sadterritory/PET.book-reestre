<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_title' => 'sometimes|string',
            'author_id' => 'sometimes|integer|exists:authors,id',
            'genre' => 'sometimes|string',
            'genres.*' => 'integer|exists:genres,id',
            'created_at' => 'sometimes|date',
            'sort_by' => 'sometimes|in:title,created_at',
            'sort_order' => 'sometimes|in:asc,desc',
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'search' => 'sometimes|string',
        ];
    }
}
