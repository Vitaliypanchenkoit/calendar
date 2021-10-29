<?php


namespace App\Services;

use App\Helpers\CacheHelper;
use App\Helpers\ObjectHelper;
use App\Repositories\CalendarRepository;

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
        CacheHelper::deleteRecord($object, $dbTable);

        /* Remove data from DB */
        $object->delete();
    }

}
