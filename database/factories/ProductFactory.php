<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

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
        // Caminho do diretório de imagens
        $directory = public_path('storage/products');

        // Se o diretório não existir, cria-lo
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Obtém todos os arquivos de imagem no diretório
        $files = glob($directory . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        // Se houver arquivos de imagem, escolhe um aleatório. Caso contrário, usa uma imagem padrão
        $imagePath = !empty($files) ? 'products/' . basename($this->faker->randomElement($files)) : 'products/default.jpg';

        // Se a imagem escolhida não existir, copia uma imagem padrão para o diretório
        if (!File::exists(public_path('storage/' . $imagePath))) {
            File::copy(public_path('storage/products/default.jpg'), public_path('storage/' . $imagePath));
        }

        return [
            'name' => $this->faker->words(3, true),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 20),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(['Romance', 'Ficção', 'Suspense', 'Terror', 'Aventura']),
            'img_path' => $imagePath, // Caminho relativo ao diretório public
            'users_id' => User::factory(),
        ];
    }
}
