<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'order_id' => Order::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'qty' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
