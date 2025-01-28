<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    protected $model = \App\Models\Video::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => null,
        ];
    }
}
