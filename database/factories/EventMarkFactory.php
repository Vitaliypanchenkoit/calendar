<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventMark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventMarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventMark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'take_part' => rand(0, 1),
            'not_interesting' => rand(0, 1),
        ];
    }
}
