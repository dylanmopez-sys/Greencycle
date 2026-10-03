<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Seed::insert([
            ['name' => 'Roble', 'price' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pino',  'price' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cedro', 'price' => 20, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
