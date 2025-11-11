<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'module_id' => Module::factory(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => fake()->paragraph(2),
            'position' => fake()->numberBetween(0, 50),
        ];
    }
}
