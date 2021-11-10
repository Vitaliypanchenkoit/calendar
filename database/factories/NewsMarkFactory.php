<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsMark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsMarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsMark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'news_id' => News::factory(),
            'user_id' => User::factory(),
            'important' => rand(0, 1),
            'read' => rand(0, 1),
        ];
    }
}
