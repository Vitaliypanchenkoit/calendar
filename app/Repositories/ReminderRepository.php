<?php


namespace App\Repositories;


use App\Models\Reminder;
use App\Repositories\Interfaces\ReminderRepositoryInterface;

class ReminderRepository implements ReminderRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getRemindersForNow()
    {
        $now = now();
        return Reminder::where('date', $now->format('Y-m-d'))
            ->where('time', '<=', $now->startOfMinute()->format('H:m:s'))
            ->get();
    }

    /**
     * @return mixed
     */
    public function getRemindersForToday()
    {
        $now = now();
        return Reminder::where('date', $now->format('Y-m-d'))
            ->where('time', '>=', $now->startOfMinute()->format('H:m:s'))
            ->get();
    }

}
