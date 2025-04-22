<?php

namespace App\Http\Requests;

use App\Enums\PublicationType;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * It is necessary in case of updating routes (protection will still work)
     */
    public function authorize(): bool
    {
        $book = $this->route('book');
        return $book->author_id == auth()->id || auth()->user()->role === UserRole::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_title' => 'sometimes|string|max:255|unique:books,book_title',
            #'author_id' => 'sometimes|integer|exists:authors,id', <-- это админовская фича :)
            'edition' => 'sometimes|string|max:255in:' . implode(',', PublicationType::values()),
        ];
    }
}
