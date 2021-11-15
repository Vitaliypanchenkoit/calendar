<?php

namespace App\Console\Commands;

use App\Events\TimeToRemindEvent;
use App\Models\Reminder;
use App\Repositories\ReminderRepository;
use App\Services\LoggerChainService\Logger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Remind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reminders and remind to user if needed';

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
            $repository = new ReminderRepository();
            $reminders = $repository->getRemindersForNow();

            if ($reminders->count()) {
                foreach ($reminders as $reminder) {
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $reminder->date . ' ' . substr($reminder->time, 0, 8));

                    if ($reminder->time_hold &&
                        $reminder->time_hold !== '00:00:00'
                    ) {
                        $timeHold = Carbon::createFromFormat('H:i:s', $reminder->time_hold);
                        $date = $date->addHours($timeHold->hour)->addMinutes($timeHold->minute);
                    }

                    $now = now();
                    if ($now->greaterThanOrEqualTo($date)) {
                        TimeToRemindEvent::dispatch($reminder);
                    }
                }
            }

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
            return 1;
        }
        return 0;
    }
}
