<?php

namespace Database\Factories;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resep>
 */
class ResepFactory extends Factory
{
    protected $model = Resep::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'bahan' => fake()->paragraph(2),
            'langkah' => fake()->paragraph(3),
            'gambar' => null,
            'user_id' => User::factory(),
        ];
    }
}
