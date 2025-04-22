<?php

namespace App\Http\Requests;

use App\Enums\PublicationType;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === UserRole::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_title' => 'required|string|max:255|unique:books,book_title',
            'author_id' => 'required|integer|exists:authors,id',
            'edition' => 'required|string|max:255|in:' . implode(',', PublicationType::values()),
        ];
    }
}
