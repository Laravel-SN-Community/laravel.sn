<?php

namespace Database\Factories;

use App\Models\Chapter;
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
        $title = fake()->sentence(4);

        return [
            'chapter_id' => Chapter::factory(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => fake()->paragraphs(5, true),
            'video_url' => fake()->boolean(60) ? fake()->url() : null,
            'duration' => fake()->numberBetween(5, 60),
            'position' => fake()->numberBetween(0, 50),
        ];
    }
}
