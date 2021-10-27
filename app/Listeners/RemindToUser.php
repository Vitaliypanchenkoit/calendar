<?php

namespace App\Listeners;

use App\Events\TimeToRemindEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RemindToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TimeToRemindEvent  $event
     * @return void
     */
    public function handle(TimeToRemindEvent $event)
    {
        //
    }
}
