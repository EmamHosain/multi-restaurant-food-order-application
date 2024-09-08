<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Menu;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word;
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? null,
            'city_id' => City::inRandomOrder()->first()->id ?? null,
            'menu_id' => Menu::inRandomOrder()->first()->id,
            'client_id' => Client::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'code' => $this->faker->bothify('PRD-#####'),
            'qty' => $this->faker->numberBetween(1, 100),
            'size' => $this->faker->randomElement(['2cm', '5cm', '8cm', '10cm']),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'discount_price' => $this->faker->optional()->randomFloat(2, 5, 50),
            'image' => $this->faker->imageUrl(300, 300, 'products', true),
            'most_popular' => $this->faker->boolean ? '1' : '0',
            'best_seller' => $this->faker->boolean ? '1' : '0',
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
