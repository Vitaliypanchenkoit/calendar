<?php

namespace App\Listeners;

use App\Events\CreateUpdateEvent;
use App\Notifications\EventParticipantWasInvitedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        try {
            $participants = $createUpdateEvent->participants;
            if ($participants) {
                foreach ($participants as $participant) {
                    $participant->notify(new EventParticipantWasInvitedNotification($createUpdateEvent->event));
                }
            }

        } catch (\Throwable $e) {
            Log::error('Participant notification error: ' . $e->getMessage());
        }
    }
}
