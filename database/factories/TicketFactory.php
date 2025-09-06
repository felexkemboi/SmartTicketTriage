<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'confidence' => $this->faker->randomFloat(2, 0, 1),            
            'category' => $this->faker->randomElement(['technical', 'payments', 'inquiries', 'feedback', 'appointment']),
            'status' => $this->faker->randomElement(['open', 'pending', 'closed']),
        ];
    }
}
