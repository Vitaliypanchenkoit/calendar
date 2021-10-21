<?php

namespace App\Services\ObserverService\Observers;

use App\Models\User;
use App\Notifications\EventParticipantWasInvitedNotification;

class NotifyParticipant implements \SplObserver
{
    public function __construct(public User $user)
    {

    }

    public function update(\SplSubject $subject)
    {
        $this->user->notify(new EventParticipantWasInvitedNotification($subject->event, $this->user));
    }

}
