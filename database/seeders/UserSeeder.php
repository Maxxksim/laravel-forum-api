<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        for ($count = 1; $count <= 2; $count++) {
            User::create([
                    'username' => "maxsima4ka$count",
                    'first_name' => fake()->firstName,
                    'last_name' => fake()->lastName,
                    'email' => fake()->unique()->safeEmail(),
                    'password' => Hash::make('blek2004'),
                ]
            );
        }
    }
}
