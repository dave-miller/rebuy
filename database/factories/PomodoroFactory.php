<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\PomodoroType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pomodoro>
 */
class PomodoroFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => PomodoroType::all()->random()->id,
            'is_active' => fake()->boolean(),
            'task' => fake()->realTextBetween(20,75),
            'duration' => fake()->numberBetween(10, 90),
            'started_at' => now(),
            'ended_at' => now(),
        ];
    }
}
