<?php

namespace Tests\Feature\Console;

use App\Models\News;
use App\Models\NewsMark;
use App\Models\Option;
use App\Models\Reminder;
use App\Repositories\OptionRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClearOldDataTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return Option
     */
    public function set_option(): Option
    {
        return $this->createOrUpdateOptionTest();
    }

    /**
     * @test
     */
    public function nothing_for_clearing()
    {
        $this->createOption();
        $this->createOrUpdateOptionTest();
    }

    /**
     * @test
     * @dataProvider provideDataForClearing
     * @param \Closure $data
     * @throws \ReflectionException
     */
    public function clear_data(\Closure $data)
    {
        $this->createOption();
        $data = $data();
        $this->artisan('clear:all')->assertExitCode(0);
        $reflection = new \ReflectionClass($data['object']);
        $className= $reflection->getName();
        $record = $className::find($data['object']->id);
        $this->assertNull($record);
    }

    /**
     * Data provider
     * @return array
     */
    public function provideDataForClearing(): array
    {
        return [
            'Reminders' => [
                function () {
                    $object = Reminder::factory()->create();
                    $object->date = now()->subDays(Reminder::NUMBER_OF_DAYS_FOR_OLD_REMINDERS + 1)->format('Y-m-d');
                    $object->save();
                    return ['object' => $object];
                }
            ],
            'News without marking' => [
                function () {
                    $object = News::factory()->create();
                    $object->date = now()->subDays(News::NUMBER_OF_DAYS_FOR_OLD_NEWS + 1)->format('Y-m-d');
                    $object->save();
                    return ['object' => $object];
                }
            ],
            'News marked as non important' => [
                function () {
                    $newsMark = NewsMark::factory()->create();
                    $newsMark->important = 0;
                    $newsMark->save();
                    $object = News::find($newsMark->news_id);
                    $object->date = now()->subDays(News::NUMBER_OF_DAYS_FOR_OLD_NEWS + 1)->format('Y-m-d');
                    $object->save();
                    return ['object' => $object];
                }
            ],
        ];

    }

    /**
     * @test
     * @dataProvider provideDataThatShouldNotBeCleared
     * @param \Closure $data
     * @throws \ReflectionException
     */
    public function dont_clear_data(\Closure $data)
    {
        $this->createOption();
        $data = $data();
        $this->artisan('clear:all')->assertExitCode(0);
        $reflection = new \ReflectionClass($data['object']);
        $className= $reflection->getName();
        $record = $className::find($data['object']->id);
        $this->assertSame($data['object']->id, $record->id);

    }

    /**
     * Data provider
     */
    public function provideDataThatShouldNotBeCleared()
    {
        return [
            'Reminders' => [
                function () {
                    $object = Reminder::factory()->create();
                    $object->date = now()->subDays(Reminder::NUMBER_OF_DAYS_FOR_OLD_REMINDERS - 1)->format('Y-m-d');
                    $object->save();
                    return ['object' => $object];
                }
            ],
            'Fresh News' => [
                function () {
                    $object = News::factory()->create();
                    $object->date = now()->subDays(News::NUMBER_OF_DAYS_FOR_OLD_NEWS - 1)->format('Y-m-d');
                    $object->save();
                    return ['object' => $object];
                }
            ],
            'Important News' => [
                function () {
                    $newsMark = NewsMark::factory()->create();
                    $newsMark->important = 1;
                    $newsMark->save();
                    $object = News::find($newsMark->news_id);
                    $object->date = now()->subDays(News::NUMBER_OF_DAYS_FOR_OLD_NEWS + 1)->format('Y-m-d');
                    $object->save();
                    return ['object' => $object];
                }
            ],
        ];

    }

    private function createOrUpdateOptionTest()
    {
        $this->artisan('clear:all')->assertExitCode(0);

        $nextClear = now()->addHours(36)->format('Y-m-d H');

        $repository = new OptionRepository();
        $option = $repository->getOptionByKey(Option::OPTION_TIME_CLEAR_OLD_DATA);

        $this->assertEquals($nextClear, $option->value);

        return $option;
    }

    private function createOption()
    {
        $time = now()->subHours(37)->format('Y-m-d H');
        Option::create([
            'key' => Option::OPTION_TIME_CLEAR_OLD_DATA,
            'value' => $time
        ]);
    }


}
