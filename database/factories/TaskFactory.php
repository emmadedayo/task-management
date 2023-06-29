<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $authenticatedUserId = Auth::id();
        return [
            //
            'task_name' => $this->faker->sentence,
            'task_description' => $this->faker->paragraph,
            'task_status' => $this->faker->randomElement(['PENDING','IN-PROGRESS','BLOCKER','COMPLETED']),
            'task_priority' => $this->faker->randomElement(['LOW', 'MEDIUM', 'HIGH']),
            'task_due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'task_start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => $authenticatedUserId
        ];
    }
}
