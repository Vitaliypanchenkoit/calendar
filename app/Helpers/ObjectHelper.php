<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class ObjectHelper
{
    public static function getDbTableName(string $objectName): string
    {
        $objectName = preg_replace('#.*\\\\#' , '', $objectName);
        return $objectName === 'News' ? mb_strtolower($objectName) : mb_strtolower($objectName) . 's';
    }

    /**
     * Clear data from cache and database
     * @param Collection $objectCollection
     */
    public static function clearObjects(Collection $objectCollection)
    {
        $className = get_class($objectCollection->first());
        $dbTable = self::getDbTableName($className);

        foreach ($objectCollection as $object) {
            /* Remove data from cache */
            CacheHelper::deleteRecord($object, $dbTable);
        }

        $ids = $objectCollection->keyBy('id')->keys()->toArray();
        $className::destroy($ids);

    }

}
