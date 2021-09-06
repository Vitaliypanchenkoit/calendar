<?php


namespace App\Repositories;


use App\Repositories\Interfaces\CalendarRepositoryInterface;

class CalendarRepository implements CalendarRepositoryInterface
{
    /**
     * @param string $objectName
     * @param string $date
     * @return mixed
     */
    public function getDateObjects(string $objectName, string $date)
    {
        return $objectName::where('date', $date)->orderBy('time')->get();
    }

    /**
     * @param string $objectName
     * @param int $id
     * @return mixed
     */
    public function getObject(string $objectName, int $id)
    {
        return $objectName::find($id);
    }

}
