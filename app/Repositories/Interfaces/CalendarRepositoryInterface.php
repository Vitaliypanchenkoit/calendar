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

    /**
     * @param string $objectName
     * @param int $id
     * @return mixed
     */
    public function getObject(string $objectName, int $id);

}
