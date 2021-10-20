<?php

namespace App\Sevices\ObserverService\Observers;

use App\Models\User;

class NotifyParticipant implements \SplObserver
{
    public function __construct(public User $user)
    {

    }

    public function update(\SplSubject $subject)
    {
        echo 1;
    }

}
