<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'content' => fake()->realText(200),
            'sent_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'read' => fake()->boolean(70),
            'created_at' => function (array $attributes) {
                return $attributes['sent_at'];
            },
            'updated_at' => function (array $attributes) {
                return $attributes['sent_at'];
            }
        ];
    }
}