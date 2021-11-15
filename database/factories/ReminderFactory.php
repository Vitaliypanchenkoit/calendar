<?php

namespace Database\Factories;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReminderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reminder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $futureDate = now()->addDays(2);
        return [
            'title' => $this->faker->title,
            'date' => $futureDate->format('Y-m-d'),
            'time' => $this->faker->date('H:i:s'),
            'time_hold' => '00:00:00',
            'author_id' => User::factory(),
            'content' => $this->faker->text
        ];
    }
}
