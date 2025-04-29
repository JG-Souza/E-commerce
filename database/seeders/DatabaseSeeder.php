<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->state([
            'name' => 'Joao Gabriel',
            'email' => 'joaogsouzafma@gmail.com',
            'password' => Hash::make('password'),
        ])->create();

        User::factory(18)->state([
            'password' => Hash::make('password'),
        ])->create();

        Admin::factory(6)->create();

        Admin::factory()->create([
            'name' => 'AdminUser',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        Product::factory(36)->create();
    }
}
