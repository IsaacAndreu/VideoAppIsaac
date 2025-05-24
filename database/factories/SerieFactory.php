<?php

namespace Database\Factories;

use App\Models\Serie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SerieFactory extends Factory
{
    protected $model = Serie::class;

    public function definition()
    {
        return [
            'title'          => $this->faker->sentence(),
            'description'    => $this->faker->paragraph(),
            'image'          => $this->faker->imageUrl(),
            'user_name'      => $this->faker->name(),
            'user_photo_url' => $this->faker->imageUrl(100,100),
            'published_at'   => $this->faker->dateTime(),
            // 'user_id' queda fora de $fillable, assigna’l si cal en el test
        ];
    }
}
