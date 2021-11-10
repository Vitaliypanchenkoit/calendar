<?php

namespace Tests\Feature\Controllers\CalendarDateController;

use App\Models\EventMark;
use App\Models\NewsMark;
use App\Models\Reminder;
use App\Models\User;
use App\Services\CalendarProxyService\CachingData;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetDateDataTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/date';
    const METHOD = 'GET';

    /**
     * @test
     */
    public function get_data_successfully()
    {
        $now = now();
        $tomorrow = $now->addDay();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['year' => $tomorrow->year, 'month' => $tomorrow->month, 'date' => $tomorrow->day]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'news',
            'events',
            'reminders'
        ]);

    }

    /**
     * @test
     */
    public function get_data_with_records_successfully()
    {
        $newsMark = NewsMark::factory()->create();
        $eventMark = EventMark::factory()->create();
        $reminder = Reminder::factory()->create();

        $date = Carbon::createFromFormat('Y-m-d', $reminder->date);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['year' => $date->year, 'month' => $date->month, 'date' => $date->day]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'news' => [
                '*' => [
                    'id',
                    'title',
                    'date',
                    'time',
                    'author_id',
                    'content',
                    'created_at',
                    'updated_at',
                    'author_name',
                    'read',
                    'important'
                ]
            ],
            'events' => [
                '*' => [
                    'id',
                    'title',
                    'date',
                    'time',
                    'author_id',
                    'content',
                    'created_at',
                    'updated_at',
                    'author_name',
                    'take_part',
                    'not_interesting',
                    'participants'
                ]
            ],
            'reminders' => [
                '*' => [
                    'id',
                    'title',
                    'date',
                    'time',
                    'time_hold',
                    'author_id',
                    'content',
                    'status',
                    'created_at',
                    'updated_at',
                ]
            ]
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
                    'date' => $tomorrow->day,
                ]
            ],
            'non integer year' => [
                [
                    'year' => 'next',
                    'month' => $tomorrow->month,
                    'date' => $tomorrow->day,
                ]
            ],
            'year before 2020' => [
                [
                    'year' => 2019,
                    'month' => $tomorrow->month,
                    'date' => $tomorrow->day,
                ]
            ],
            'year after 2100' => [
                [
                    'year' => 2101,
                    'month' => $tomorrow->month,
                    'date' => $tomorrow->day,
                ]
            ],
            'missing month' => [
                [
                    'year' => $tomorrow->year,
                    'date' => $tomorrow->day,
                ]
            ],
            'non integer month' => [
                [
                    'year' => $tomorrow->year,
                    'month' => 'April',
                    'date' => $tomorrow->day,
                ]
            ],
            'zero month' => [
                [
                    'year' => $tomorrow->year,
                    'month' => 0,
                    'date' => $tomorrow->day,
                ]
            ],
            'thirteenth month' => [
                [
                    'year' => $tomorrow->year,
                    'month' => 13,
                    'date' => $tomorrow->day,
                ]
            ],
            'missing date' => [
                [
                    'year' => $tomorrow->year,
                    'month' => $tomorrow->month,
                ]
            ],
            'non integer date' => [
                [
                    'year' => $tomorrow->year,
                    'month' => $tomorrow->month,
                    'date' => 'tomorrow',
                ]
            ],
            'date 0' => [
                [
                    'year' => $tomorrow->year,
                    'month' => $tomorrow->month,
                    'date' => 0,
                ]
            ],
            'date 32' => [
                [
                    'year' => $tomorrow->year,
                    'month' => $tomorrow->month,
                    'date' => 32,
                ]
            ],
        ];
    }
}
