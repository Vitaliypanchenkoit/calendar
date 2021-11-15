<?php

namespace Tests\Feature\Controllers\CalendarDateController;

use App\Models\Event;
use App\Models\EventMark;
use App\Models\News;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteObjectTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/removeObject';
    const METHOD = 'POST';

    /**
     * @dataProvider provideObjectData
     * @test
     * @param \Closure $data
     * @return void
     */
    public function delete_object_successfully(\Closure $data)
    {
        $data = $data();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertOk();
    }

    /**
     * @test
     * @dataProvider provideInvalidData
     */
    public function failed_validation(array|\Closure $data)
    {
        if (is_object($data)) {
            $data = $data();
        }

        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertStatus(422);

    }

    /**
     * @dataProvider
     * @return \Closure[][]
     */
    public function provideObjectData()
    {
        return [
            'delete Reminder' => [
                function () {
                    $object = Reminder::factory()->create();
                    return [
                        'id' => $object->id,
                        'objectName' => 'Reminder'
                    ];
                }
            ],
            'delete Event' => [
                function () {
                    $object = Event::factory()->create();
                    return [
                        'id' => $object->id,
                        'objectName' => 'Event'
                    ];
                }
            ],
            'delete News' => [
                function () {
                    $object = News::factory()->create();
                    return [
                        'id' => $object->id,
                        'objectName' => 'News'
                    ];
                }
            ],

        ];

    }

    /**
     * Data provider
     * @return array
     */
    public function provideInvalidData(): array
    {
        return [
            'missing all fields' => [[]],
            'missing objectName' => [
                function () {
                    $reminder = Reminder::factory()->create();
                    return ['id' => $reminder->id];
                }
            ],
            'invalid objectName' => [
                function () {
                    $eventMark = EventMark::factory()->create();
                    return [
                        'objectName' => 'EventMark',
                        'id' => $eventMark->id
                    ];
                }
            ],
            'missing id' => [
                [
                    'objectName' => 'Reminder'
                ]
            ],
            'non integer id' => [
                [
                    'objectName' => 'Reminder',
                    'id' => 'hfh'
                ]
            ],
            'non existing reminder id' => [
                [
                    'objectName' => 'Reminder',
                    'id' => 0
                ]
            ],
            'non existing event id' => [
                [
                    'objectName' => 'Event',
                    'id' => 0
                ]
            ],
            'non existing news id' => [
                [
                    'objectName' => 'News',
                    'id' => 0
                ]
            ],

        ];
    }
}
