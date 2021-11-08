<?php

namespace Tests\Feature\Controllers\EventController;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateEventTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/events';
    const METHOD = 'PUT';

    /**
     * @test
     * @dataProvider provideVariantsForUpdating
     * @return void
     */
    public function update_an_event_successfully(array $data)
    {
        $event = Event::factory()->create();
        $user = User::find($event->author_id);

        $data['id'] = $event->id;

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertStatus(200);
    }

    /**
     * @test
     * @dataProvider provideInvalidData
     * @return void
     */
    public function fail_validation(array|\Closure $data)
    {
        if (is_object($data)) {
            $data = $data();
        }

        if (!empty($data['id'])) {
            $event = Event::find($data['id']);
            $user = User::find($event->author_id);
        } else {
            $user = User::factory()->create();
        }

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertStatus(422);
    }

    /**
     * @test
     * @return void
     */
    public function user_hasnt_an_access_to_update_an_event()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $tomorrow = now()->addDay();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, [
            'id' => $event->id,
            'title' => 'new title',
            'content' => 'new content',
            'date' => $tomorrow,
            'time' => $tomorrow,
        ]);

        $response->assertForbidden();
    }

    /**
     * Data provider
     * @return array
     */
    public function provideInvalidData(): array
    {
        $now = now();
        $tomorrow = $now->addDay();
        return [
            'missing all fields' => [[]],
            'missing id' => [
                [
                    'title' => 'new title',
                    'content' => 'new content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                ]
            ],
            'not existing id' => [
                [
                    'id' => 0,
                    'title' => 'new title',
                    'content' => 'new content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                ]
            ],
            'missing title' => [
                function () {
                    $event = Event::factory()->create();
                    $tomorrow = now()->addDay();
                    return [
                        'id' => $event->id,
                        'content' => 'new content',
                        'date' => $tomorrow,
                        'time' => $tomorrow,
                    ];
                }
            ],
            'missing content' => [
                function () {
                    $event = Event::factory()->create();
                    $tomorrow = now()->addDay();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'date' => $tomorrow,
                        'time' => $tomorrow,
                    ];
                }
            ],
            'missing date' => [
                function () {
                    $event = Event::factory()->create();
                    $tomorrow = now()->addDay();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'time' => $tomorrow,
                    ];
                }
            ],
            'missing time' => [
                function () {
                    $event = Event::factory()->create();
                    $tomorrow = now()->addDay();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'date' => $tomorrow,
                    ];
                }
            ],
            'past date' => [
                function () {
                    $event = Event::factory()->create();
                    $yesterday = now()->subDay();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'date' => $yesterday,
                        'time' => $yesterday,
                    ];
                }
            ],
            'past time' => [
                function () {
                    $event = Event::factory()->create();
                    $now = now();
                    $minuteAgo = $now->subMinute();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'date' => $now,
                        'time' => $minuteAgo,
                    ];
                }
            ],
            'invalid participants' => [
                function () {
                    $event = Event::factory()->create();
                    $now = now();
                    $minuteAgo = $now->subMinute();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'date' => $now,
                        'time' => $minuteAgo,
                    ];
                }
            ],
            'invalid participants string' => [
                function () {
                    $event = Event::factory()->create();
                    $tomorrow = now()->addDay();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'date' => $tomorrow,
                        'time' => $tomorrow,
                        'participants' => 'sfsdfdsf'
                    ];
                }
            ],
            'invalid participants type' => [
                function () {
                    $event = Event::factory()->create();
                    $tomorrow = now()->addDay();
                    return [
                        'id' => $event->id,
                        'title' => 'new title',
                        'content' => 'new content',
                        'date' => $tomorrow,
                        'time' => $tomorrow,
                        'participants' => ['test@mail.com']
                    ];
                }
            ],

        ];
    }

    /**
     * Data provider
     * @return array
     */
    public function provideVariantsForUpdating(): array
    {
        $tomorrow = now()->addDay();
        return [
            'with participants' => [
                [
                    'title' => 'new title',
                    'content' => 'new content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                    'participants' => json_encode(['test123@mail.com', 'test1234@gmail.com'])
                ]
            ],
            'without participants' => [
                [
                    'title' => 'new title',
                    'content' => 'new content',
                    'date' => $tomorrow,
                    'time' => $tomorrow,
                ]
            ],

        ];

    }
}
