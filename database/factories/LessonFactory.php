<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->sentence(3);

        return [
            'slug' => fake()->unique()->slug(),
            'name' => $name,
            'summary' => fake()->paragraph(),
            'link' => fake()->url(),
            'chapter_id' => \App\Models\Chapter::factory(),
        ];
    }
}
