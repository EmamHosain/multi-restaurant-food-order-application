<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'photo' => $this->faker->imageUrl(200, 200, 'people', true, 'client'),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'role' => 'client',
            'status' => '1', // default active status
            'token' => Str::random(10), // random token for password reset
            'remember_token' => Str::random(10),
        ];
    }
}
