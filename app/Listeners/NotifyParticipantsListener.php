<?php

namespace App\Listeners;

use App\Events\CreateUpdateEvent;
use App\Notifications\EventParticipantWasInvitedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyParticipantsListener implements ShouldQueue
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
     * @param  CreateUpdateEvent $createUpdateEvent
     * @return void
     */
    public function handle(CreateUpdateEvent $createUpdateEvent)
    {
        $participants = $createUpdateEvent->event->participants();
        if ($participants) {
            foreach ($participants as $participant) {
                $participant->notify(new EventParticipantWasInvitedNotification($createUpdateEvent->event));
            }
        }
    }
}
