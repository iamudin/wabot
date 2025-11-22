<?php

namespace Database\Factories;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SyaratLayananFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'layanan_id' => Layanan::factory(),
            'nama' => fake()->word(),
            'keterangan' => fake()->word(),
            'jenis_syarat' => fake()->randomElement(["file","text"]),
            'status' => fake()->boolean(),
            'urutan' => fake()->numberBetween(-8, 8),
            'sumber_data' => fake()->randomElement(["user","database"]),
        ];
    }
}
