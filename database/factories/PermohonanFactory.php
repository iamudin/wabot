<?php

namespace Database\Factories;

use App\Models\Layanan;
use App\Models\Pemohon;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermohonanFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'layanan_id' => Layanan::factory(),
            'sesi_dimulai' => fake()->dateTime(),
            'sesi_berakir' => fake()->dateTime(),
            'status_permohonan' => fake()->word(),
            'penduduk_id' => Penduduk::factory(),
            'pemohon_id' => Pemohon::factory(),
        ];
    }
}
