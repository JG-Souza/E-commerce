<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; // Correto, aqui estamos usando Hash para a senha

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
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
        $imagePath = $files ? 'storage/images/' . basename($this->faker->randomElement($files)) : null;

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'logradouro' => $this->faker->streetName(),
            'numero' => $this->faker->randomNumber(3),
            'bairro' => $this->faker->randomElement([
                'Centro', 'Jardins', 'Vila Madalena', 'Copacabana', 'Moema', 'Boa Viagem', 'Leblon', 'Ipanema', 'Santana', 'Barra da Tijuca'
            ]),
            'city' => $this->faker->city(),
            'state' => $this->faker->randomElement([
                'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
                'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
                'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
            ]),
            'cep' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
            'cpf' => $this->faker->numberBetween(100000000, 999999999), // Gambiarra
            'img_path' => $imagePath
        ];
    }
}

