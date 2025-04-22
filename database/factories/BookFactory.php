<?php

namespace Database\Factories;

use App\Enums\PublicationType;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'book_title' => $this->faker->unique()->sentence(3),
            'author_id' => Author::inRandomOrder()->first()->id ?? Author::factory(),
            'edition' => $this->faker->randomElement(PublicationType::cases())->value,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $book->genres()->attach(
                Genre::inRandomOrder()
                    ->limit(rand(1, 3))
                    ->pluck('id')
            );
        });
    }
}