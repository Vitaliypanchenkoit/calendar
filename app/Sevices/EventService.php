<?php

namespace App\Sevices;

use App\Helpers\CacheHelper;
use App\Models\Event;
use App\Models\EventMark;
use App\Repositories\EventMarkRepository;

class EventService
{
    public function __construct(private EventMarkRepository $repository)
    {

    }

    /**
     * @param int $eventId
     * @param int $userId
     * @param int|null $takePart
     * @param int|null $notInteresting
     */
    public function markEvent(int $eventId, int $userId, int $takePart = null, int $notInteresting = null)
    {
        $eventMark = $this->repository->getEventBy($eventId, $userId);

        if (!$eventMark) {
            $eventMark = new EventMark();
            $eventMark->event_id = $eventId;
            $eventMark->user_id = $userId;
        }

        $eventMark->take_part = $takePart ?? null;
        $eventMark->not_interesting = $notInteresting ?? null;
        $eventMark->save();

        /* Update cache data */
        $event = Event::with('participants')->where('id', $eventId)->first();

        $event->participants = $event->participants->keyBy('id');
        $event->unsetRelation('participants');

        $event->participants[$userId]->take_part = $takePart ?? null;
        $event->participants[$userId]->not_interesting = $notInteresting ?? null;

        CacheHelper::createOrUpdateRecord(CacheHelper::EVENTS, $event->date, $event);
    }

}
