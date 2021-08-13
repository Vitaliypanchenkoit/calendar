<?php

namespace App\Sevices\CalendarProxyService;

use App\Models\Event;
use App\Models\News;
use App\Models\Reminder;
use App\Repositories\CalendarRepository;
use Illuminate\Support\Facades\Cache;

class CalendarData implements CalendarDataInterface
{
    private CalendarRepository $calendarRepository;

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

        Cache::put($date, json_encode(['news' => $result['news'], 'events' => $result['events'], 'reminders' => $result['reminders']]));

        return $result;

    }


}
