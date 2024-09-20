<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'payment_type' => $this->faker->randomElement(['Credit Card', 'Cash on Delivery']),
            'payment_method' => $this->faker->randomElement(['PayPal', 'Cash on Delivery']),
            'transaction_id' => Str::random(10),
            'currency' => 'USD', // Adjust based on your application requirements
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'total_amount' => $this->faker->randomFloat(2, 10, 500),
            'order_number' => Str::random(8),
            'invoice_no' => Str::random(6),
            'order_date' => $this->faker->date(),
            'order_month' => $this->faker->monthName(),
            'order_year' => $this->faker->year(),
            'confirmed_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            'processing_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            'shipped_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            'delivered_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            'status' => $this->faker->randomElement(
                [
                    'Processing',
                    'Deliverd',
                    'Confirmed',
                    'Pending'
                ]
            ),
        ];
    }
}
