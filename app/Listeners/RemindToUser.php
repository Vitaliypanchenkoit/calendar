<?php

namespace App\Listeners;

use App\Events\TimeToRemind;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  TimeToRemind  $event
     * @return void
     */
    public function handle(TimeToRemind $event)
    {
        //
    }
}
