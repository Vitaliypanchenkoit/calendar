<?php

namespace Tests\Feature\Console;

use App\Events\TimeToRemindEvent;
use App\Models\Reminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RemindTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider provideFutureReminder
     */
    public function nothing_to_remind(array|\Closure $data)
    {
        if (is_object($data)) {
            $data = $data();
        }

        Event::fake();

        $this->artisan('remind:run')->assertExitCode(0);

        Event::assertNotDispatched(TimeToRemindEvent::class);

    }

    /**
     * @test
     * @dataProvider provideUpToDateReminder
     */
    public function remind_successfully(\Closure $data)
    {
        $data = $data();

        Event::fake();

        $this->artisan('remind:run')->assertExitCode(0);

        Event::assertDispatched(TimeToRemindEvent::class);

    }

    /**
     * Data provider
     * @return array
     */
    public function provideFutureReminder()
    {
        return [
            'Without reminders' => [[]],
            'Reminder is not for now' => [
                function () {
                    $object = Reminder::factory()->create();
                    return ['object' => $object];
                }
            ],
            'Holded Reminder' => [
                function () {
                    $now = now();
                    $object = Reminder::factory()->create();
                    $object->date = $now->format('Y-m-d');
                    $object->time = $now->subMinutes(10)->format('H:i:s');
                    $object->time_hold = '01:00:00';
                    $object->save();
                    return ['object' => $object];
                }
            ],
        ];

    }

    /**
     * Data provider
     * @return array
     */
    public function provideUpToDateReminder()
    {
        return [
            'Reminder for now' => [
                function () {
                    $now = now();
                    $object = Reminder::factory()->create();
                    $object->date = $now->format('Y-m-d');
                    $object->time = $now->format('H:m:s');
                    $object->save();
                    return ['object' => $object];
                }
            ],
            'Holded Reminder for now' => [
                function () {
                    $now = now();
                    $object = Reminder::factory()->create();
                    $object->date = $now->format('Y-m-d');
                    $object->time = $now->subHour()->format('H:i:s');
                    $object->time_hold = '01:00:00';
                    $object->save();
                    return ['object' => $object];
                }
            ],
        ];

    }
}
