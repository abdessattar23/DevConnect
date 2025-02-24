<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->city() . ', ' . fake()->country(),
            'contract_type' => fake()->randomElement(['CDI', 'CDD', 'Freelance']),
            'offer_link' => fake()->url(),
            'date_published' => fake()->dateTimeBetween('-3 months', 'now'),
            'created_at' => function (array $attributes) {
                return $attributes['date_published'];
            },
            'updated_at' => function (array $attributes) {
                return $attributes['date_published'];
            }
        ];
    }
}