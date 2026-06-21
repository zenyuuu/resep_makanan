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
        // Buat test users dengan credentials yang sesuai dengan config.py
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@perusahaan.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Andi Karyawan',
            'email' => 'andi@perusahaan.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        // Buat beberapa user tambahan untuk testing
        $users = User::factory(5)->create();

        // Seed reseps dengan data realistic
        $this->call(ResepSeeder::class);
    }
}
