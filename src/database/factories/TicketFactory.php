<?php

namespace Database\Factories;

use App\Enum\TicketStatusEnum;
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
            'subject' => $this->faker->sentence(),
            'text' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TicketStatusEnum::cases()),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
