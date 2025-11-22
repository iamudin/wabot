<?php

namespace Database\Factories;

use App\Models\Rw;
use Illuminate\Database\Eloquent\Factories\Factory;

class RtFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'rw_id' => Rw::factory(),
            'nomor' => fake()->word(),
        ];
    }
}
