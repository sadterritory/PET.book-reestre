<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'book_title' => $this->book_title,
            'author_first_name' => $this->author->first_name,
            'author_last_name' => $this->author->last_name,
            'edition' => $this->edition,
        ];
    }
}
