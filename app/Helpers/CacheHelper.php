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
        $cacheKey = auth()->user()->id . '_' . $date;
        if (!Cache::has($cacheKey)) {
            $forSave = ['news' => [], 'events' => [], 'reminders' => []];
        } else {
            $forSave = json_decode(Cache::get($cacheKey), true);
        }

        $forSave[$type][] = $value;
        Cache::put(auth()->user()->id . '_' . $date, json_encode($forSave));

    }

}
