<?php


namespace App\Repositories;


use App\Models\Reminder;
use App\Repositories\Interfaces\ClearDataRepositoryInterface;
use App\Repositories\Interfaces\ReminderRepositoryInterface;

class ReminderRepository implements ReminderRepositoryInterface, ClearDataRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getRemindersForNow()
    {
        $now = now();
        return Reminder::where('date', $now->format('Y-m-d'))
            ->where('time', '<=', $now->startOfMinute()->format('H:i:s'))
            ->where('status', '<>', Reminder::STATUS_COMPLETED)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getRemindersForToday()
    {
        $now = now();
        return Reminder::where('date', $now->format('Y-m-d'))
            ->where('status', '<>', Reminder::STATUS_COMPLETED)
            ->get();
    }

    /**
     * @param int $numberOfDays
     * @return mixed
     */
    public function getOldData(int $numberOfDays)
    {
        $now = now();
        $before = $now->subDays($numberOfDays)->format('Y-m-d');
        return Reminder::where('date', '<=', $before)->get();

    }

}
