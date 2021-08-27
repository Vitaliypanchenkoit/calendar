<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    public const REMINDERS = 'reminders';
    public const NEWS = 'news';
    public const EVENTS = 'events';

    public static function createOrUpdateRecord($type, $date, $value)
    {
        if (!Cache::has($date)) {
            $forSave = ['news' => [], 'events' => [], 'reminders' => []];
        } else {
            $forSave = json_decode(Cache::get($date), true);
        }

        $forSave[$type][$value->id] = $value;
        Cache::put($date, json_encode($forSave));

    }

}
