<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class LayananFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::factory(),
            'nama_layanan' => fake()->word(),
            'keterangan' => fake()->text(),
            'status' => fake()->boolean(),
        ];
    }
}
