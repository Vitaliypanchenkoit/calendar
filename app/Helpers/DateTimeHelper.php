<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateTimeHelper
{
    /**
     * @param $date
     * @param $time
     * @throws \Exception
     */
    public static function checkPastDate($date, $time)
    {
        $now = now();
        $carbon = new Carbon($date . ' ' . $time);

        if ($now->timestamp >= $carbon->timestamp) {
            throw new \Exception(__('You are trying to set future date or time'), 400);
        }

    }

}
