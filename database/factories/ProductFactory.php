<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $directory = public_path('storage/products');

        $files = glob($directory . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        $imagePath = $files ? 'storage/products/' . basename($this->faker->randomElement($files)) : null;

        return [
            'name' => $this->faker->words(3, true),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 20),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(['Romance', 'Ficção', 'Suspense', 'Terror', 'Aventura']),
            'img_path' => $imagePath,
            'users_id' => User::factory(),
        ];
    }
}
