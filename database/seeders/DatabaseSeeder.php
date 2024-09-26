<?php

namespace Database\Seeders;

use App\Models\City;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Factories\CategoryFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([AdminSeeder::class, PermissionSeeder::class]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->count(100)->create();
        $faker = Faker::create();
        Client::create([
            'name' => 'client',
            'email' => 'client@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'photo' => $faker->imageUrl(200, 200, 'people', true, 'client'),
            'phone' => $faker->phoneNumber(),
            'address' => $faker->address(),
            'role' => 'client',
            'status' => '1', // default active status
            'token' => Str::random(10), // random token for password reset
            'remember_token' => Str::random(10),
        ]);
        Client::factory()->count(10)->create();
        Category::factory()->count(70)->create();
        City::factory()->count(20)->create();
        Menu::factory()->count(100)->create();
        Product::factory()->count(200)->create();
        Gallery::factory()->count(20)->create();
        Order::factory()->count(100)->create();
        OrderItem::factory()->count(200)->create();

    }
}
