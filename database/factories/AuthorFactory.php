<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->unique()->firstName(),
            'last_name' => $this->faker->unique()->lastName(),
            'email' => $this->faker->unique()->email(),
        ];
    }
}