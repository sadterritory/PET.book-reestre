<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorId = $this->route('author');
        $author = Author::find($authorId);
        if (!$author) {
            abort(404, 'Author not found');
        }
        return (string)$author->user_id == (string)auth()->id() || auth()->user()->role === UserRole::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:authors,email,' . auth()->id(),
        ];
    }
}
