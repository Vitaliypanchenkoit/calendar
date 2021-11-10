<?php

namespace Tests\Feature\Controllers\CalendarDateController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetMonthDataTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/month';
    const METHOD = 'GET';

    /**
     * @test
     */
    public function get_data_successfully()
    {
        $now = now();
        $tomorrow = $now->addDay();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['year' => $tomorrow->year, 'month' => $tomorrow->month]);

        $endOfMonth = $tomorrow->endOfMonth()->day;
        $dates = [];
        for ($i = 1; $i <= $endOfMonth; $i++) {
            $dates[] = strval($i);
        }

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'dates',
            'news' => $dates,
            'events' => $dates,
            'reminders' => $dates,
            'remindersForToday'
        ]);

    }

    /**
     * @test
     * @dataProvider provideInvalidData
     */
    public function failed_validation(array $data)
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertStatus(422);

    }

    /**
     * Data provider
     * @return array
     */
    public function provideInvalidData(): array
    {
        $tomorrow = now()->addDay();
        return [
            'missing all fields' => [[]],
            'missing year' => [
                [
                    'month' => $tomorrow->month,
                ]
            ],
            'non integer year' => [
                [
                    'year' => 'next',
                    'month' => $tomorrow->month,
                ]
            ],
            'year before 1970' => [
                [
                    'year' => 1969,
                    'month' => $tomorrow->month,
                ]
            ],
            'year after 3000' => [
                [
                    'year' => 3001,
                    'month' => $tomorrow->month,
                ]
            ],
            'missing month' => [
                [
                    'year' => $tomorrow->year,
                ]
            ],
            'non integer month' => [
                [
                    'year' => $tomorrow->year,
                    'month' => 'April'
                ]
            ],
            'zero month' => [
                [
                    'year' => $tomorrow->year,
                    'month' => 0
                ]
            ],
            'thirteenth month' => [
                [
                    'year' => $tomorrow->year,
                    'month' => 13
                ]
            ],
        ];
    }
}
