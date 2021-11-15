<?php

namespace Tests\Feature\Controllers\ReminderController;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditReminderTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/reminders/edit';
    const METHOD = 'GET';

    /**
     *
     * @return void
     */
    public function test_get_edit_reminder_page_successfully()
    {
        $reminder = Reminder::factory()->create();
        $user = User::find($reminder->author_id);
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $reminder->id]);

        $response->assertStatus(200);
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
