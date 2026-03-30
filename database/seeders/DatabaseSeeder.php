<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $products = [
            ['name' => 'Laptop', 'description' => 'High performance laptop', 'price' => 1200.00, 'image_url' => 'https://picsum.photos/seed/laptop/400/300'],
            ['name' => 'Smartphone', 'description' => 'Latest model smartphone', 'price' => 800.00, 'image_url' => 'https://picsum.photos/seed/phone/400/300'],
            ['name' => 'Headphones', 'description' => 'Noise-cancelling headphones', 'price' => 150.00, 'image_url' => 'https://picsum.photos/seed/headphones/400/300'],
            ['name' => 'Monitor', 'description' => '4K Ultra HD Monitor', 'price' => 300.00, 'image_url' => 'https://picsum.photos/seed/monitor/400/300'],
            ['name' => 'Keyboard', 'description' => 'Mechanical keyboard', 'price' => 100.00, 'image_url' => 'https://picsum.photos/seed/keyboard/400/300'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
