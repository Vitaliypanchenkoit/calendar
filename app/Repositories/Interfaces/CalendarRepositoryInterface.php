<?php


namespace App\Repositories\Interfaces;


interface CalendarRepositoryInterface
{
    /**
     * @param string $objectName
     * @param string $date
     * @return mixed
     */
    public function getDateObjects(string $objectName, string $date);

}
