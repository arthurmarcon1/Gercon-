<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'unit_id' => Unit::factory(),
            'user_id' => null,
            'name' => fake()->name(),
            'document' => fake()->numerify('###.###.###-##'),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'active' => true,
        ];
    }

    public function withLogin(): static
    {
        return $this->state(['user_id' => \App\Models\User::factory()]);
    }

    public function inactive(): static
    {
        return $this->state(['active' => false]);
    }
}
