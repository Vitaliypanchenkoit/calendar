<?php

namespace App\Services\CalendarProxyService;

interface CalendarDataInterface
{
    public function getDayData(string $date);

}
