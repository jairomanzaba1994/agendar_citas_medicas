<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'active' => $this->faker->boolean(),
            'morning_start' => $this->faker->time(),
            'morning_end' => $this->faker->time(),
            'afternoon_start' => $this->faker->time(),
            'afternoon_end' => $this->faker->time(),
            'user_id' => '3',
        ];
    }
}
