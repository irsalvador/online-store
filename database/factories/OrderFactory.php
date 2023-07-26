<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Order Factory
 * @author IR Salvador
 * @since 2023.07.25
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * @return \Closure[]
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create(['user_type' => 'admin'])->id;
            }
        ];
    }
}

