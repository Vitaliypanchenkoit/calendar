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

    /**
     * @param object $object
     * @param string $dbTable
     */
    public static function deleteRecord(object $object, string $dbTable)
    {
        $dateData = Cache::get($object->date);
        if ($dateData) {
            $dateData = json_decode($dateData, true);
            unset($dateData[$dbTable][$object->id]);
            Cache::put($object->date, json_encode($dateData));
        }

    }

}
