<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word();
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'menu_name' => $name,
            'slug' => Str::slug($name),
            'image' => $this->faker->imageUrl(300, 300, 'menu', true, 'menu'),
        ];
    }
}
