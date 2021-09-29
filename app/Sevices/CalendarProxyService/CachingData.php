<?php

namespace App\Sevices\CalendarProxyService;

use Illuminate\Support\Facades\Cache;

class CachingData implements CalendarDataInterface
{
    /**
     * @var CalendarData
     */
    private CalendarData $calendarDataService;

    /**
     *
     */
    public function __construct()
    {
        $this->calendarDataService = new CalendarData();
    }

    /**
     * @param string $date
     * @return array
     */
    public function getDayData(string $date): array
    {
        $result = $this->calendarDataService->getDayData($date);
//        if (!Cache::has($date)) {
//        } else {
//            $result = json_decode(Cache::get($date), true);
//        }

        return $result;
    }

}
