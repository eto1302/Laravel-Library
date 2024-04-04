<?php

namespace Database\Factories;

use App\Domains\Book\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BookFactory.
 */
class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author' => $this->faker->name(),
            'title' => $this->faker->sentence(),
            'year' => $this->faker->numberBetween(1900, 2022),
            'genre' => $this->faker->word(),
        ];
    }
}
