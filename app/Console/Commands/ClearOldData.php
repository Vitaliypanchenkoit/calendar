<?php

namespace App\Console\Commands;

use App\Helpers\ObjectHelper;
use App\Models\News;
use App\Models\Option;
use App\Models\Reminder;
use App\Repositories\NewsRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ReminderRepository;
use App\Services\LoggerChainService\Logger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $isTime = $this->checkTime();
            Log::info(__('Time of clearing old data was checked at') . ' ' . now()->format('Y-m-d H:i:s') . ' ' .  __('Result:') . ' ' . print_r($isTime, true));

            if (!$isTime) {
                return 0;
            }

            // All repositories should implement ClearDataRepositoryInterface
            $items = [
                ['repositoryName' => ReminderRepository::class, 'numberOfDays' => Reminder::NUMBER_OF_DAYS_FOR_OLD_REMINDERS],
                ['repositoryName' => NewsRepository::class, 'numberOfDays' => News::NUMBER_OF_DAYS_FOR_OLD_NEWS],
            ];

            foreach ($items as $item) {
                $repository = new $item['repositoryName'];
                $objectCollection = $repository->getOldData($item['numberOfDays']);

                if ($objectCollection->count()) {
                    ObjectHelper::clearObjects($objectCollection);
                }
            }

            Log::info(__('Old data was clear at ' . now()->format('Y-m-d H:i:s')));

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
        }
        return 0;
    }

    /**
     * @return int
     */
    private function checkTime(): int
    {
        $repository = new OptionRepository();
        $option = $repository->getOptionByKey(Option::OPTION_TIME_CLEAR_OLD_DATA);

        $nextClear = now()->addHours(36)->format('Y-m-d H');

        if (!$option) {
            Option::create([
                'key' => Option::OPTION_TIME_CLEAR_OLD_DATA,
                'value' => $nextClear
            ]);
            return 0;
        }

        $shouldClearAt = Carbon::createFromFormat('Y-m-d H', $option->value);

        if (now()->greaterThanOrEqualTo($shouldClearAt)) {
            Option::where('key', Option::OPTION_TIME_CLEAR_OLD_DATA)
                ->update(['value' => $nextClear]);
            return 1;
        }

        return 0;
    }
}
