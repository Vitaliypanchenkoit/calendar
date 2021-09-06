<?php

namespace App\Console\Commands;

use App\Repositories\ReminderRepository;
use Illuminate\Console\Command;

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

        }
        return 0;
    }
}
