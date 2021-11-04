<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompleteReminderTest extends TestCase
{
    /**
     * @return void
     */
    public function test_forbid_an_unauthenticated_user_to_complete_a_reminder()
    {
        $reminder = Reminder::factory()->create();
        $response = $this->json('PUT', '/reminders/complete', [
            'id' => $reminder->id,
        ]);

        $response->assertUnauthorized();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_complete_reminder_successfully()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);
        $response = $this->actingAs($user)->json('PUT', '/reminders/complete', ['id' => $reminder->id]);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_user_hasnt_access_to_complete_a_reminder()
    {
        $reminder = Reminder::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( 'PUT', '/reminders/complete', ['id' => $reminder->id]);

        $response->assertForbidden();
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array $data)
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( 'PUT', '/reminders/complete', $data);

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
            'not existing id' => [
                [
                    'id' => 0,
                ]
            ],

        ];
    }
}
