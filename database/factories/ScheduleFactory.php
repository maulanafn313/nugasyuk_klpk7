<?php

namespace Database\Factories;

use App\Models\User;
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
            'schedule_name' => $this->faker->sentence(3),
            'schedule_category' => $this->faker->randomElement(['task', 'activities']),
            'priority' => $this->faker->randomElement(['important','very important', 'not important']),
            'start_schedule' => $this->faker->dateTimeBetween('now', '+1 week'),
            'due_schedule' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'before_due_schedule' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'upload_file' => $this->faker->randomElement(['file1.pdf', 'file2.docx', 'file3.jpg']),
            'url' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['to-do','processed', 'completed', 'overdue']),
        ];
    }
}
