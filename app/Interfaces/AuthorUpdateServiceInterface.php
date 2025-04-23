<?php

namespace App\Interfaces;

use App\Models\Author;

interface AuthorUpdateServiceInterface {
    public function updateAuthor(array $data, string $id): Author;
}
