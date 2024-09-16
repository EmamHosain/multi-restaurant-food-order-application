<?php

namespace Database\Factories;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'coupon_name' => strtoupper($this->faker->word),
            'coupon_desc' => $this->faker->paragraph,
            'validity_date' => date('Y-m-d', strtotime('+1 day')), // Validity date one day from now
            'status' => $this->faker->randomElement([0, 1]), // Example of random status
            'discount' => $this->faker->randomFloat(2, 5, 50), // Example of random discount
        ];
    }
}
