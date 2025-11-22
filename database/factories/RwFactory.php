<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RwFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nomor' => fake()->word(),
        ];
    }
}
