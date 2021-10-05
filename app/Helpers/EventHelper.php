<?php

namespace App\Helpers;

use App\Models\Event;

class EventHelper
{
    /**
     * @param Event $event
     * @return Event
     */
    public static function reformat(Event $event)
    {
        $event->take_part = $event->eventMarks->where('take_part', 1)->keyBy('user_id')->keys();
        $event->not_interesting = $event->eventMarks->where('not_interesting', 1)->keyBy('user_id')->keys();
        $event->unsetRelation('eventMarks');
        return $event;
    }

}
