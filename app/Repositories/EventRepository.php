<?php


namespace App\Repositories;


use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getSingleEvent(int $id)
    {
        return Event::select(['*'])
            ->where('id', $id)
            ->with('newsMarks')
            ->first();
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function getDateEvents(string $date)
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
