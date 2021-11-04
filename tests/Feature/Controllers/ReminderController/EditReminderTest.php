<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditReminderTest extends TestCase
{
    /**
     * @return void
     */
    public function test_forbid_an_unauthenticated_user_to_edit_a_reminder()
    {
        $reminder = Reminder::factory()->create();
        $response = $this->json('GET', '/reminders/edit', [
            'id' => $reminder->id,
        ]);

        $response->assertUnauthorized();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_edit_reminder_page_successfully()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);
        $response = $this->actingAs($user)->json('GET', '/reminders/edit', ['id' => $reminder->id]);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array $data)
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( 'GET', '/reminders/edit', $data);

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
