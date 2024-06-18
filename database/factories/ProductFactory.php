<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => 'Product ' . fake()->name(),
            'code'  => 'PRD' . strtoupper(Str::random(5)),
            'type'  => fake()->randomElement(['oil', 'coolant', 'other']),
        ];
    }
}
