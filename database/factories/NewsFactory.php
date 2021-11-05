<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = now();
        return [
            'title' => $this->faker->title,
            'date' => $now->format('Y-m-d'),
            'time' => $now->format('H:i:s'),
            'author_id' => User::factory(),
            'content' => $this->faker->text
        ];
    }
}
