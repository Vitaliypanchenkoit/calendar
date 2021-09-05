<?php

namespace App\Sevices\CalendarProxyService;

use App\Models\Event;
use App\Models\News;
use App\Models\Reminder;
use App\Repositories\CalendarRepository;
use Illuminate\Support\Facades\Cache;

class CalendarData implements CalendarDataInterface
{
    /**
     * @var CalendarRepository
     */
    private CalendarRepository $calendarRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->calendarRepository = new CalendarRepository();
    }

    /**
     * @param string $date
     * @return array
     */
    public function getDayData(string $date): array
    {
        $result = [];
        $result['news'] = $this->calendarRepository->getDateObjects(News::class, $date);
        $result['events'] = $this->calendarRepository->getDateObjects(Event::class, $date);
        $result['reminders'] = $this->calendarRepository->getDateObjects(Reminder::class, $date);

        if ($result['news']->count() ||
            $result['events']->count() ||
            $result['reminders']->count()
        ) {
            Cache::put($date, json_encode(['news' => $result['news']->keyBy('id'), 'events' => $result['events']->keyBy('id'), 'reminders' => $result['reminders']->keyBy('id')]));
        }

        return $result;

    }
}
