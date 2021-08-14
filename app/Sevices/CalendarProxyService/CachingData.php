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
        $cacheKey = auth()->user()->id . '_' . $date;

        if (!Cache::has($cacheKey)) {
            $result = $this->calendarDataService->getDayData($date);
        } else {
            $result = json_decode(Cache::get($cacheKey), true);
        }

        return $result;
    }

}
