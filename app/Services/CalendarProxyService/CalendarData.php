<?php

namespace App\Services\CalendarProxyService;

use App\Helpers\EventHelper;
use App\Helpers\NewsHelper;
use App\Models\Event;
use App\Models\Reminder;
use App\Repositories\CalendarRepository;
use App\Repositories\EventRepository;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Cache;

class CalendarData implements CalendarDataInterface
{
    /**
     * @var CalendarRepository
     */
    private CalendarRepository $calendarRepository;

    /**
     * @var NewsRepository
     */
    private NewsRepository $newsRepository;

    /**
     * @var EventRepository
     */
    private EventRepository $eventRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->calendarRepository = new CalendarRepository();
        $this->newsRepository = new NewsRepository();
        $this->eventRepository = new EventRepository();
    }

    /**
     * @param string $date
     * @return array
     */
    public function getDayData(string $date): array
    {
        $result = [];

        $result['news'] = $this->newsRepository->getDateNews($date);
        if ($result['news']->count()) {
            /* Here we created two additional attributes "read" and "important" in each news object and store an array of user's id into them */
            foreach ($result['news'] as $k => $v) {
                $result['news'][$k] = NewsHelper::reformatNews($v);
            }
        }

        $result['events'] = $this->eventRepository->getDateEvents($date);
        if ($result['events']->count()) {
            /* Here we created two additional attributes "take_part" and "not_interesting" in each event object and store an array of user's id into them */
            foreach ($result['events'] as $k => $v) {
                $result['events'][$k] = EventHelper::reformat($v);
            }
        }
        $result['reminders'] = $this->calendarRepository->getDateObjects(Reminder::class, $date);

        if ($result['news']->count() ||
            $result['events']->count() ||
            $result['reminders']->count()
        ) {
            Cache::put($date, json_encode([
                'news' => $result['news']->keyBy('id'),
                'events' => $result['events']->keyBy('id'),
                'reminders' => $result['reminders']->keyBy('id')
            ]));
        }

        return $result;

    }
}
