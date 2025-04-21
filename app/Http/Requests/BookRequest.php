<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'id' => 'required|integer|exists:books,id',
            'book_title' => 'required|string|max:255|unique:books,book_title',
            'book_author' => 'required|string|max:255',
            'book_genre' => 'required|string|max:255',
            'edition' => 'required|string|max:255',
            'author_id' => 'required|integer|exists:authors,id',
        ];
    }
}
