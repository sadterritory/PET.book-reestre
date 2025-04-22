<?php

namespace App\Models;

use App\Enums\PublicationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'book_title',
        'author_id',
        'edition',
    ];

    protected $casts = [
        'edition' => PublicationType::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'book_genres',
            'book_id',
            'genre_id')->withTimestamps();
    }

}
