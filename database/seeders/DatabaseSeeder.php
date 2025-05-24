<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'afif',
            'role' => 'admin',
            'email' => 'afif@example.com',
            'password' => 'afif1234',
        ]);
        User::factory()->create([
            'name' => 'dimas',
            'role' => 'kasir',
            'email' => 'dimas@example.com',
            'password' => 'dimas123',
        ]);
        User::factory()->create([
            'name' => 'ubay',
            'role' => 'pengguna',
            'email' => 'ubay@example.com',
            'password' => 'ubay1234',
        ]);
    }
}
