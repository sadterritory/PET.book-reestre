<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{

    protected $table = 'books';

    protected $guarded = false;

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function genre(): BelongsToMany
    {
        return $this->BelongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

}
