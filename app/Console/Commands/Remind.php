<?php

namespace App\Console\Commands;

use App\Events\TimeToRemindEvent;
use App\Models\Reminder;
use App\Repositories\ReminderRepository;
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
        Log::debug('Event was dispatched');
        $repository = new ReminderRepository();
        $reminder = Reminder::find(1);
        TimeToRemindEvent::dispatch($reminder);
//        $repository = new ReminderRepository();
//        $reminders = $repository->getRemindersForNow();
//        if ($reminders->count()) {
//            foreach ($reminders as $reminder) {
//                TimeToRemindEvent::dispatch($reminder);
//            }
//
//        }
        return 0;
    }
}
