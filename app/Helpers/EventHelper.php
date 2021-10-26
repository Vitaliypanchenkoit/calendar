<?php

namespace App\Helpers;

use App\Models\Event;

class EventHelper
{
    /**
     * Set new properties "take_part", "not_interesting" from relation
     * @param Event $event
     * @return Event
     */
    public static function reformat(Event $event): Event
    {


        $event->take_part = $event->eventMarks->where('take_part', 1)->keyBy('user_id')->keys();
        $event->not_interesting = $event->eventMarks->where('not_interesting', 1)->keyBy('user_id')->keys();
        $event->unsetRelation('eventMarks');
        return $event;
    }

    /**
     * Set new property "participants" from relation
     * @param Event $event
     * @return Event
     */
    public static function reformatParticipants(Event $event): Event
    {
        $participants = $event->participants;
        $event->participants = $participants ? $participants->keyBy('email')->keys()->toArray() : [];
        $event->unsetRelation('participants');
        return $event;
    }

}
