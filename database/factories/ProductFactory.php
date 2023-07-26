<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Product Model
 * @author IR Salvador
 * @since 2023.07.25
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array|mixed[]
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 100)
        ];
    }
}

