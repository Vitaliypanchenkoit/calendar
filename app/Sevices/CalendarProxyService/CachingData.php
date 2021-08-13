<?php

namespace App\Sevices\CalendarProxyService;

use Illuminate\Support\Facades\Cache;

class CachingData implements CalendarDataInterface
{
    private CalendarData $calendarDataService;

    public function __construct()
    {
        $this->calendarDataService = new CalendarData();
    }

    public function getDayData(string $date): array
    {
        if (!Cache::has($date)) {
            $result = $this->calendarDataService->getDayData($date);
        } else {
            $result = json_decode(Cache::get($date));
        }

        return $result;
    }

}
