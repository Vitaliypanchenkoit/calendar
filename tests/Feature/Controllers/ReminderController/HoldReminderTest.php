<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HoldReminderTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/reminders/hold';
    const METHOD = 'PUT';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_hold_reminder_successfully()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $reminder->id, 'period' => 30]);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_user_hasnt_access_to_hold_a_reminder()
    {
        $reminder = Reminder::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, ['id' => $reminder->id, 'period' => 30]);

        $response->assertForbidden();
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array|\Closure $data)
    {
        if (is_object($data)) {
            $data = $data();
        }

        if (!empty($data['id'])) {
            $reminder = Reminder::find($data['id']);
            $user = User::find($reminder->author_id);
        } else {
            $user = User::factory()->create();
        }

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
            'missing all fields' => [[]],
            'missing id' => [
                [
                    'period' => 30
                ]
            ],
            'not existing id' => [
                [
                    'id' => 0,
                    'period' => 30
                ]
            ],
            'missing period' => [
                function () {
                    $reminder = Reminder::factory()->create();
                    return ['id' => $reminder->id];
                }
            ],
            'non numeric period' => [
                function () {
                    $reminder = Reminder::factory()->create();
                    return ['id' => $reminder->id, 'period' => 'test'];
                }
            ]

        ];
    }
}
