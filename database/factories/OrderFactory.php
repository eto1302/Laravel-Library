<?php

namespace Database\Factories;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Models\Order;
use App\Domains\Book\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'book_id' => $this->faker->numberBetween(1, 100),
            'user_id' => $this->faker->numberBetween(1, 100),
            'return_date' => today()->addMonth(),
        ];
    }
}
