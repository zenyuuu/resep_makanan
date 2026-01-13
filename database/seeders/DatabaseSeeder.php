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
        // Buat beberapa user
        $users = User::factory(5)->create();

        // Seed reseps dengan data realistic
        $this->call(ResepSeeder::class);
    }
}
