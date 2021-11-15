<?php

namespace Tests\Feature\Controllers\EventController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/events';
    const METHOD = 'POST';

    /**
     * @test
     * @return void
     */
    public function create_an_event_without_participants_successfully()
    {
        $user = User::factory()->create();
        $tomorrow = now()->addDay();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, [
            'title' => 'test title',
            'content' => 'test content',
            'date' => $tomorrow,
            'time' => $tomorrow,
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function create_an_event_with_participants_successfully()
    {
        $user = User::factory()->create();
        $tomorrow = now()->addDay();

        $participants = json_encode(['test1@mail.com', 'test2@gmail.com']);

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, [
            'title' => 'test title',
            'content' => 'test content',
            'date' => $tomorrow,
            'time' => $tomorrow,
            'participants' => $participants
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     * @dataProvider provideInvalidData
     * @return void
     */
    public function fail_validation(array $data)
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
        $now = now();
        $tomorrow = now()->addDay();
        $yesterday = now()->subDay();
        $minuteAgo = $now->subMinute();
        return [
            'missing all fields' => [[]],
            'missing title' => [
                [
                    'content' => 'test content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                ]
            ],
            'missing content' => [
                [
                    'title' => 'test title',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                ]
            ],
            'missing date' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'time' => $tomorrow,
                ]
            ],
            'missing time' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'date' => $tomorrow,
                ]
            ],
            'set past date' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'date' => $yesterday,
                    'time' => $now,
                ]
            ],
            'set past time' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'date' => $now,
                    'time' => $minuteAgo,
                ]
            ],
            'invalid participants string' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                    'participants' => 'sfsdfdsf'
                ]
            ],
            'invalid participants type' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                    'participants' => ['test@mail.com']
                ]
            ],
        ];
    }
}
