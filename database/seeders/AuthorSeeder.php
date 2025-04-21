<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            ['first_name' => 'John', 'last_name' => 'Doe'],
            ['first_name' => 'Jane', 'last_name' => 'Smith'],
            ['first_name' => 'Robert', 'last_name' => 'Johnson'],
            ['first_name' => 'Emily', 'last_name' => 'Williams'],
            ['first_name' => 'Michael', 'last_name' => 'Brown'],
            ['first_name' => 'Sarah', 'last_name' => 'Jones'],
            ['first_name' => 'David', 'last_name' => 'Miller'],
            ['first_name' => 'Lisa', 'last_name' => 'Davis'],
            ['first_name' => 'James', 'last_name' => 'Garcia'],
            ['first_name' => 'Jennifer', 'last_name' => 'Rodriguez'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}