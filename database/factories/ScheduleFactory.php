<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
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
            'user_id' => User::factory(),
            'category_schedule_id' => Category::factory(),
            'schedule_name' => fake()->sentence(3),
            'priority' => fake()->randomElement(['important', 'very_important', 'not_important']),
            'start_schedule' => now()->addDays(rand(1, 5)),
            'due_schedule' => now()->addDays(rand(6, 10)),
            'before_due_schedule' => now()->addDays(rand(5, 6)),
            'upload_file' => fake()->filePath(),
            'url' => fake()->url(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['to-do','processed', 'completed', 'overdue']),
        ];
    }
}
