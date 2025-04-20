<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{

    protected $table = 'books';

    protected $guarded = false;

    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    public function genre(): BelongsToMany
    {
        return $this->BelongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

}
