<?php

namespace Database\Factories;

use App\Models\Rt;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->regexify('[A-Za-z0-9]{16}'),
            'nama' => fake()->word(),
            'jenis_kelamin' => fake()->randomElement(["L","P"]),
            'alamat' => fake()->word(),
            'rt_id' => Rt::factory(),
            'agama' => fake()->word(),
            'status_kawin' => fake()->word(),
            'nomor_whatsapp' => fake()->word(),
            'terdaftar_pada' => fake()->dateTime(),
            'terverifikasi_pada' => fake()->dateTime(),
        ];
    }
}
