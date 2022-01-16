<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->word,
            'category' => $this->faker->word,
            'price' => $this->faker->randomFloat(2,100, 10000),
            'quantity' => $this->faker->randomDigit(),
            'manufacturer' => $this->faker->company,
            'distributor' => $this->faker->company,
        ];
    }
}
