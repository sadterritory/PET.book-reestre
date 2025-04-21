<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            ['genre_name' => 'Science Fiction'],
            ['genre_name' => 'Fantasy'],
            ['genre_name' => 'Mystery'],
            ['genre_name' => 'Thriller'],
            ['genre_name' => 'Romance'],
            ['genre_name' => 'Horror'],
            ['genre_name' => 'Historical Fiction'],
            ['genre_name' => 'Biography'],
            ['genre_name' => 'Self-Help'],
            ['genre_name' => 'Science'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}