<?php

namespace Database\Factories;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->unique()->slug(),
            'content' => '<p>' . $this->faker->paragraphs(3, true) . '</p>',
            'status' => ArticleStatus::Published,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ArticleStatus::Draft,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ArticleStatus::Published,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
