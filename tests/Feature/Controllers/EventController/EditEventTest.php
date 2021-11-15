<?php

namespace Tests\Feature\Controllers\EventController;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditEventTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/events/edit';
    const METHOD = 'GET';

    /**
     * @test
     * @return void
     */
    public function get_event_successfully()
    {
        $event = Event::factory()->create();
        $user = User::find($event->author_id);
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $event->id]);

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
        return [
            'missing id' => [[]],
            'not existing id' => [
                [
                    'id' => 0
                ]
            ],

        ];
    }
}
