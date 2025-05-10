<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cms>
 */
class CmsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color' => '#0086FF',
            'logo' => 'https://example.com/logo.png',
            'hero_text' => 'Manage Your Task Easily with Nugasyuk',
            'description_text' => 'Organize, schedule, and track your tasks to boost your productivity. Start now and never miss a deadline!',
            'hero_text2' => 'Stay on Track with Visual Planning',
            'description_text2' => "Visualize your tasks with an intuitive calendar and task view. Whether you're a student or a professional, Nugas Yuk! helps you stay focused and productive.",
            'img_text2' => 'https://example.com/visual_planning.png',
            'hero_text3' => "Powerful Features to Boost Your Productivity Intuitive Calendar View",
            'description_text3' => "Plan your week with our easy-to-use calendar interface. Drag and drop tasks, set recurring events, and get a clear overview of your upcoming schedule at a glance.",
            'img_text3' => "https://example.com/calendar_view.png",
            'hero_text4' => "Smart Task Management",
            'description_text4' => "Plan your week with our easy-to-use calendar interface. Drag and drop tasks, set recurring events, and get a clear overview of your upcoming schedule at a glance.",
            'img_text4' => "https://example.com/task_management.png",
        ];
    }
}
