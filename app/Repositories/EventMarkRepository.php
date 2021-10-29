<?php

namespace App\Repositories;

use App\Models\EventMark;
use App\Repositories\Interfaces\EventMarkRepositoryInterface;

class EventMarkRepository implements EventMarkRepositoryInterface
{
    /**
     * @param int $eventId
     * @param int $userId
     * @return mixed
     */
    public function getEventBy(int $eventId, int $userId)
    {
        return EventMark::where(['event_id' => $eventId, 'user_id' => $userId])->first();
    }

}
