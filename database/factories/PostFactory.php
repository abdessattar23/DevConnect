<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(2, true),
            'image_url' => fake()->optional(0.7)->imageUrl(640, 480, 'technology'),
            'code_snippet' => fake()->optional(0.3)->text(200),
            'published_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'created_at' => function (array $attributes) {
                return $attributes['published_date'];
            },
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at']);
            }
        ];
    }
}