<?php


namespace App\Services;

use App\Helpers\ObjectHelper;
use App\Repositories\CalendarRepository;
use Illuminate\Support\Facades\Cache;

class CalendarService
{
    /**
     * Delete the Object from Cache and Database
     * @param string $objectName
     * @param int $id
     */
    public function deleteObject(string $objectName, int $id): void
    {
        $repository = new CalendarRepository();
        $object = $repository->getObject('App\\Models\\' . $objectName, $id);

        $dbTable = ObjectHelper::getDbTableName($objectName);

        /* Remove data from cache */
        $dateData = Cache::get($object->date);
        if ($dateData) {
            $dateData = json_decode($dateData, true);
            unset($dateData[$dbTable][$id]);
            Cache::put($object->date, json_encode($dateData));
        }

        /* Remove data from DB */
        $object->delete();
    }

}
