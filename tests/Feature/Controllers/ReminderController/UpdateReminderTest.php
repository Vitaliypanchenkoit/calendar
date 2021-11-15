<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateReminderTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/reminders';
    const METHOD = 'PUT';

    /**
     * @return void
     */
    public function test_update_a_reminder_successfully()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, [
            'id' => $reminder->id,
            'time' => now(),
        ]);

        $response->assertStatus(200);
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
     * @return void
     */
    public function test_user_hasnt_access_to_update_reminder()
    {
        $reminder = Reminder::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, ['id' => $reminder->id, 'time' => now()]);

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
                    'time' => $tomorrow,
                ]
            ],
            'not existing id' => [
                [
                    'id' => 0,
                    'time' => $tomorrow,
                ]
            ],
            'missing time' => [
                function () {
                    $reminder = Reminder::factory()->create();
                    return ['id' => $reminder->id];
                }
            ],

        ];
    }
}
