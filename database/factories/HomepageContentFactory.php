<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomePageContent>
 */
class HomepageContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Manage your tasks easily with Nugayuk',
            'body' => 'Nugayuk is a task management application that helps you organize your tasks efficiently. With its user-friendly interface, you can easily create, edit, and delete tasks. You can also set deadlines and priorities for each task to ensure that you stay on track.',
            'image_url' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fHRhc2t8ZW58MHx8fHwxNjg3NTY5NzA1&ixlib=rb-4.0.3&q=80&w=400',
        ];
    }
}
