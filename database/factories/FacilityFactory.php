<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;

        $facilities = [
            [
                'img' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fHRhc2t8ZW58MHx8fHwxNjg3NTY5NzA1&ixlib=rb-4.0.3&q=80&w=400',
                'title' => 'Create Schedules',
                'description' => 'Easily create and customize your own task schedules with intuitive tools.',
            ],
            [
                'img' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fHRhc2t8ZW58MHx8fHwxNjg3NTY5NzA1&ixlib=rb-4.0.3&q=80&w=400',
                'title' => 'View & Track',
                'description' => 'Monitor your progress and keep your tasks organized with visual dashboards.',
            ],
            [
                'img' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fHRhc2t8ZW58MHx8fHwxNjg3NTY5NzA1&ixlib=rb-4.0.3&q=80&w=400',
                'title' => 'Get Things Done',
                'description' => 'Achieve your goals with effective task management and productivity insights.',
            ],
        ];

        $data = $facilities[$index];
        $index = ($index + 1) % count($facilities); // Increment index and reset if it exceeds the array length

        return $data;
    }
}
