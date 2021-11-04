<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateReminderTest extends TestCase
{
    /**
     * @return void
     */
    public function test_forbid_an_unauthenticated_user_to_update_a_reminder()
    {
        $reminder = Reminder::factory()->create();
        $response = $this->json('PUT', '/reminders', [
            'id' => $reminder->id,
            'time' => now()->format('H:i:s'),
        ]);

        $response->assertUnauthorized();
    }

    /**
     * @return void
     */
    public function test_update_a_reminder_successfully()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);

        $response = $this->actingAs($user)->json( 'PUT', '/reminders', [
            'id' => $reminder->id,
            'time' => now(),
        ]);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array $data)
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( 'PUT', '/reminders', $data);

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_fail_validation_time()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);

        $response = $this->actingAs($user)->json( 'PUT', '/reminders', ['id' => $reminder->id]);

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_hasnt_access_to_update_reminder()
    {
        $reminder = Reminder::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( 'PUT', '/reminders', ['id' => $reminder->id, 'time' => now()]);

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

        ];
    }
}
