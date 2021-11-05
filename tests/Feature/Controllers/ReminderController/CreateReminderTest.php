<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateReminderTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/reminders';
    const METHOD = 'POST';

    /**
     * @return void
     */
    public function test_create_a_reminder_successfully()
    {
        $user = User::factory()->create();
        $tomorrow = now()->addDay();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, [
            'title' => 'test title',
            'content' => 'test content',
            'date' => $tomorrow,
            'time' => $tomorrow,
        ]);

        $response->assertStatus(201);
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array $data)
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
        $tomorrow = $now->addDay();
        $yesterday = $now->subDay();
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
                    'time' => $now,
                ]
            ],
            'missing time' => [
                [
                    'title' => 'test title',
                    'content' => 'test content',
                    'date' => $now,
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

        ];
    }
}
