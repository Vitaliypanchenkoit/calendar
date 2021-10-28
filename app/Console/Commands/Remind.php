<?php

namespace App\Console\Commands;

use App\Events\TimeToRemindEvent;
use App\Models\Reminder;
use App\Repositories\ReminderRepository;
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
        $repository = new ReminderRepository();
        $reminders = $repository->getRemindersForNow();

        if ($reminders->count()) {
            foreach ($reminders as $reminder) {
                if ($reminder->time_hold &&
                    $reminder->time_hold !== '00:00:00'
                ) {
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $reminder->date . ' ' . $reminder->time);

                    $timeHold = Carbon::createFromFormat('H:i:s', $reminder->time_hold);

                    $date = $date->addHours($timeHold->hour)->addMinutes($timeHold->minute);

                    $now = now();
                    if ($now->greaterThanOrEqualTo($date)) {
                        TimeToRemindEvent::dispatch($reminder);
                    }
                }
            }
        }
        return 0;
    }
}
