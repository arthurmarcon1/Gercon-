<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Condominium>
 */
class CondominiumFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->words(3, true) . ' Condomínio',
            'address' => [
                'street' => fake()->streetName(),
                'number' => fake()->buildingNumber(),
                'city' => fake()->city(),
                'state' => fake()->stateAbbr(),
                'zip' => fake()->numerify('#####-###'),
            ],
            'document' => fake()->numerify('##.###.###/####-##'),
            'active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => false]);
    }
}
