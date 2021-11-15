<?php

namespace Tests\Feature\Controllers\CalendarDateController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GetWeekDataTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/week';
    const METHOD = 'GET';

    /**
     * @test
     * @dataProvider provideWeekParameters
     */
    public function get_data_successfully(array $data)
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, $data);
        $responseData = $response->getData();

        $data['start'] ??= now()->startOfWeek()->format('Y-m-j');

        $weekDay = Carbon::createFromFormat('Y-m-j', $responseData->start);
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = strval($weekDay->day);
        }

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'dates',
            'news' => $dates,
            'events' => $dates,
            'reminders' => $dates,
            'months' => $dates,
            'start',
            'end'
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
    public function provideWeekParameters(): array
    {
        $now = now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-j');
        $endOfWeek = $now->endOfWeek()->format('Y-m-j');

        $nextWeek = $now->addWeek();
        $startOfNextWeek = $nextWeek->startOfWeek()->format('Y-m-j');
        $endOfNextWeek = $nextWeek->endOfWeek()->format('Y-m-j');

        $prevWeek = $now->subWeek();
        $startOfPrevWeek = $prevWeek->startOfWeek()->format('Y-m-j');
        $endOfPrevWeek = $prevWeek->endOfWeek()->format('Y-m-j');

        return [
            'this week' => [
                [
                    'start' => $startOfWeek,
                    'end' => $endOfWeek,
                ]
            ],
            'next week' => [
                [
                    'start' => $startOfNextWeek,
                    'end' => $endOfNextWeek,
                    'shift' => 'next'
                ]
            ],
            'prev week' => [
                [
                    'start' => $startOfPrevWeek,
                    'end' => $endOfPrevWeek,
                    'shift' => 'prev'
                ]
            ],
        ];
    }

    /**
     * Data provider
     * @return array
     */
    public function provideInvalidData(): array
    {
        $now = now();
        $startOfWeek = $now->startOfWeek();
        $endOfWeek = $now->endOfWeek();
        return [
            'missing start' => [
                [
                    'end' => $endOfWeek->format('Y-m-j'),
                ]
            ],
            'missing end' => [
                [
                    'start' => $startOfWeek->format('Y-m-j'),
                ]
            ],
            'invalid format of start' => [
                [
                    'start' => $startOfWeek->format('d-m-Y'),
                    'end' => $endOfWeek->format('Y-m-j'),
                ]
            ],
            'invalid format of end' => [
                [
                    'start' => $startOfWeek->format('Y-m-j'),
                    'end' => $endOfWeek->format('d-m-Y'),
                ]
            ],
            'invalid shift' => [
                [
                    'start' => $startOfWeek->format('Y-m-j'),
                    'end' => $endOfWeek->format('Y-m-j'),
                    'shift' => 'some'
                ]
            ],
        ];
    }
}
