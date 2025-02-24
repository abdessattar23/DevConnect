<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Node.js',
            'Python', 'Django', 'Java', 'Spring Boot', 'C#', '.NET',
            'SQL', 'MongoDB', 'Redis', 'Docker', 'AWS', 'Azure',
            'Git', 'CI/CD', 'TDD', 'Agile', 'Scrum', 'DevOps',
            'HTML', 'CSS', 'Sass', 'TypeScript', 'Angular', 'Flutter',
            'Swift', 'Kotlin', 'Ruby', 'Rails', 'Go', 'Rust'
        ];

        return [
            'name' => fake()->unique()->randomElement($skills),
        ];
    }
}