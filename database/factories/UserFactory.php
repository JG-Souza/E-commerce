<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'logradouro' => fake()->streetName(),
            'numero' => fake()->randomNumber(3),
            'bairro' => $this->faker->randomElement([
                'Centro', 'Jardins', 'Vila Madalena', 'Copacabana', 'Moema', 'Boa Viagem', 'Leblon', 'Ipanema', 'Santana', 'Barra da Tijuca'
            ]),
            'city' => $this->faker->city(),
            'state' => $this->faker->randomElement([
                'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
                'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
                'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
            ]),
            'cep' => fake()->postcode(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->date(),
            'cpf' => fake()->numberBetween(100000000, 999999999),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
