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
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'logradouro' => $this->faker->streetName(),
            'numero' => $this->faker->randomNumber(3),
            'bairro' => $this->faker->city(),
            'city' => $this->faker->city(),
            'state' => $this->faker->lexify('??'),
            'cep' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
            'cpf' => $this->faker->numberBetween(100000000, 999999999),
        ];
    }
}

