<?php

namespace Database\Factories;

use App\Models\Permohonan;
use App\Models\SyaratLayanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataPermohonanFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'permohonan_id' => Permohonan::factory(),
            'syarat_layanan_id' => SyaratLayanan::factory(),
            'keterangan' => fake()->word(),
            'koreksidata' => fake()->word(),
            'status' => fake()->randomElement(["dijawab","menunggu"]),
        ];
    }
}
