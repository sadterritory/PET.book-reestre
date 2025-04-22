<?php

namespace Database\Seeders;

use App\Models\Genre;
use Database\Factories\GenreFactory;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        if (Genre::exists()) {
            return;
        }

        foreach (GenreFactory::getDefaultGenres() as $genre) {
            Genre::factory()->withName($genre)->create();
        }
    }
}