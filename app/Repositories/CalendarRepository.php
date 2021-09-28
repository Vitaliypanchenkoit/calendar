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
        $tableName = $objectName::table;
        return $objectName::select($tableName . '.*', 'users.name as author_name')
            ->join('users', 'users.id', '=', $tableName . '.author_id')
            ->where($tableName . '.date', $date)
            ->orderBy($tableName . '.time')
            ->get();
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
