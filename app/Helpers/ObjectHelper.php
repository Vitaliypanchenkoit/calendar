<?php

namespace App\Helpers;

use App\Models\News;

class ObjectHelper
{
    public static function getDbTableName(string $objectName): string
    {
        return $objectName === 'News' ? mb_strtolower($objectName) : mb_strtolower($objectName) . 's';
    }

}
