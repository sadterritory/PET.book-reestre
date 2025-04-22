<?php

namespace Database\Seeders;

use App\Enums\PublicationType;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run()
    {
        DB::table('books')->truncate();
        DB::table('book_genres')->truncate();

        $books = [
            ['book_title' => 'The Silent Planet', 'author_id' => 1, 'edition' => PublicationType::DIGITAL->value],
            ['book_title' => 'Dreams of Fire', 'author_id' => 2, 'edition' => PublicationType::DIGITAL->value],
            ['book_title' => 'Midnight Murders', 'author_id' => 3, 'edition' => PublicationType::GRAPHIC->value],
            ['book_title' => 'The Last Witness', 'author_id' => 4, 'edition' => PublicationType::PRINT->value],
            ['book_title' => 'Hearts in Paris', 'author_id' => 5, 'edition' => PublicationType::DIGITAL->value],
            ['book_title' => 'Shadow of Fear', 'author_id' => 6, 'edition' => PublicationType::GRAPHIC->value],
            ['book_title' => 'The Kings War', 'author_id' => 7, 'edition' => PublicationType::PRINT->value],
            ['book_title' => 'Beyond Limits', 'author_id' => 8, 'edition' => PublicationType::DIGITAL->value],
            ['book_title' => 'Path to Success', 'author_id' => 9, 'edition' => PublicationType::GRAPHIC->value],
            ['book_title' => 'Quantum World', 'author_id' => 10, 'edition' => PublicationType::PRINT->value],
        ];

        foreach ($books as $bookData) {
            $book = Book::create($bookData);

            $genres = Genre::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id')
                ->toArray();

            $book->genres()->attach($genres);
        }
    }
}