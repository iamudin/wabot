<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sesi_dimulai' => fake()->dateTime(),
            'sesi_berakir' => fake()->dateTime(),
            'nomor_whatsapp' => fake()->word(),
        ];
    }
}
