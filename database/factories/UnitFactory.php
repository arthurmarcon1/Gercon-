<?php

namespace Database\Factories;

use App\Models\Condominium;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'condominium_id' => Condominium::factory(),
            'block_id' => null,
            'number' => (string) fake()->numberBetween(101, 999),
            'floor' => fake()->numberBetween(1, 20),
        ];
    }

    public function inBlock(\App\Models\Block $block): static
    {
        return $this->state([
            'condominium_id' => $block->condominium_id,
            'block_id' => $block->id,
        ]);
    }
}
