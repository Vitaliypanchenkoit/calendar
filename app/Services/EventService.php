<?php

namespace App\Services;

use App\Helpers\CacheHelper;
use App\Models\EventMark;
use App\Notifications\SomeoneAgreeToTakePartInEventNotification;
use App\Repositories\EventMarkRepository;
use App\Repositories\EventRepository;

class EventService
{
    /**
     * @var EventMarkRepository
     */
    private EventMarkRepository $repository;

    /**
     * @var EventRepository
     */
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->repository = new EventMarkRepository();
        $this->eventRepository = new EventRepository();
    }

    /**
     * @param int $eventId
     * @param string $key
     * @param int $value
     * @return \App\Models\Event|null
     */
    public function markEvent(int $eventId, string $key, int $value)
    {
        $user = auth()->user();
        $eventMark = $this->repository->getEventBy($eventId, $user->id);

        if (!$eventMark) {
            $eventMark = new EventMark();
            $eventMark->event_id = $eventId;
            $eventMark->user_id = $user->id;
        }

        $eventMark->{$key} = $value;
        $eventMark->save();

        /* Update cache data */
        $event = $this->eventRepository->getSingleEvent($eventId);

        CacheHelper::createOrUpdateRecord(CacheHelper::EVENTS, $event->date, $event);

        /* Notify the event author if somebody agreed to take part */
        if ($key === 'take_part' && $value) {
            $eventAuthor = $event->author;
            $eventAuthor->notify(new SomeoneAgreeToTakePartInEventNotification($event, $user));
        }

        return $event;
    }

}
