<?php

namespace Database\Factories;

use App\Models\Registrasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataRegistrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'registrasi_id' => Registrasi::factory(),
            'kata_kunci' => fake()->word(),
            'pertanyaan' => fake()->word(),
            'jawaban' => fake()->word(),
            'urutan' => fake()->numberBetween(-8, 8),
            'status' => fake()->randomElement(["dijawab","menunggu"]),
        ];
    }
}
