<?php

namespace Tests\Feature\Controllers\EventController;

use App\Models\Event;
use App\Models\EventMark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarkEventTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/events/mark';
    const METHOD = 'POST';
    const KEY_TAKE_PART = 'take_part';
    const KEY_NOT_INTERESTING = 'not_interesting';

    /**
     * @test
     * @dataProvider provideMarkVariants
     *
     * @return void
     */
    public function mark_event_successfully_by_new_user(array $data)
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $event->id, 'key' => $data['key'], 'value' => $data['value']]);
        $response->assertStatus(200);
    }

    /**
     * @test
     * @dataProvider provideMarkVariants
     *
     * @return void
     */
    public function mark_event_successfully_by_existing_user(array $data)
    {
        $eventMark = EventMark::factory()->create();
        $user = User::find($eventMark->user_id);
        $event = Event::find($eventMark->event_id);

        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $event->id, 'key' => $data['key'], 'value' => $data['value']]);
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
        $event = Event::factory()->create();

        if (isset($data['id']) && $data['id'] === '') {
            $data['id'] = $event->id;
        }

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);
        $response->assertStatus(422);
    }

    /**
     * Data provider of invalid user input
     * @return array
     */
    public function provideInvalidData(): array
    {
        return [
            'missing all fields' => [[]],
            'missing id' => [
                [
                    'key' => self::KEY_TAKE_PART,
                    'value' => 1
                ]
            ],
            'not existing id' => [
                [
                    'id' => 0,
                    'key' => self::KEY_NOT_INTERESTING,
                    'value' => 1
                ]
            ],
            'missing key' => [
                [
                    'id' => '',
                    'value' => 1
                ]
            ],
            'invalid key' => [
                [
                    'id' => '',
                    'key' => 'invalid',
                    'value' => 1
                ]
            ],
            'missing value' => [
                [
                    'id' => '',
                    'key' => self::KEY_TAKE_PART,
                ]
            ],
            'invalid value' => [
                [
                    'id' => '',
                    'key' => self::KEY_NOT_INTERESTING,
                    'value' => 2
                ]
            ],

        ];
    }

    /**
     * Data provider of mark variants
     * @return array
     */
    public function provideMarkVariants(): array
    {
        return [
            'take_part-1' => [
                [
                    'key' => self::KEY_TAKE_PART,
                    'value' => 1
                ]
            ],
            'not_interesting-1' => [
                [
                    'key' => self::KEY_NOT_INTERESTING,
                    'value' => 1
                ]
            ],
            'take_part-0' => [
                [
                    'key' => self::KEY_TAKE_PART,
                    'value' => 0
                ]
            ],
            'not_interesting-0' => [
                [
                    'key' => self::KEY_NOT_INTERESTING,
                    'value' => 0
                ]
            ],

        ];

    }
}
