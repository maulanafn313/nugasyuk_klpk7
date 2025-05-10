<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;

        $questions = [
            [
                'question' => 'How to create a schedule?',
                'answer' => 'To create a schedule, go to the "Schedules" section and click on "Create New Schedule".',
            ],
            [
                'question' => 'How to track my progress?',
                'answer' => 'You can track your progress in the "Progress" section where you can view your completed tasks.',
            ],
            [
                'question' => 'How to get support?',
                'answer' => 'For support, visit the "Support" section or contact us via email at'
            ]
            ];
        
        $data = $questions[$index];
        $index = ($index + 1) % count($questions); // Increment index and reset if it exceeds the array length

        return $data;
    }
}
