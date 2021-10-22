<?php


namespace App\Repositories;

use App\Helpers\EventHelper;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EventRepository implements EventRepositoryInterface
{
    /**
     * @param int $id
     * @return Event|null
     */
    public function getSingleEvent(int $id): ?Event
    {
        $event = Event::where('id', $id)
            ->with('eventMarks')
            ->with('participants')
            ->first();

        if ($event) {
            $event = EventHelper::reformat($event);
            $event = EventHelper::reformatParticipants($event);
        }

        return $event;
    }

    /**
     * @param string $date
     * @return Collection
     */
    public function getDateEvents(string $date): Collection
    {
        return Event::select(
            'events.*',
            'users.name as author_name')
            ->join('users', 'users.id', '=', 'events.author_id')
            ->with('eventMarks')
            ->where('events.date', $date)
            ->orderBy('events.time')
            ->get();
    }

}
