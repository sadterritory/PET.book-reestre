<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition(): array
    {
        return [
            'genre_name' => $this->faker->word,
        ];
    }

    public function withName(string $name): static
    {
        return $this->state([
            'genre_name' => $name,
        ]);
    }

    public static function getDefaultGenres(): array
    {
        return [
            'Science Fiction',
            'Fantasy',
            'Mystery',
            'Thriller',
            'Romance',
            'Horror',
            'Historical Fiction',
            'Biography',
            'Self-Help',
            'Science',
            'Dystopian',
            'Adventure',
            'Crime',
            'Young Adult',
            'Children\'s'
        ];
    }
}