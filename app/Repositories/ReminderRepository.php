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
        $currentUser = auth()->user();
        return Reminder::where('date', $now->format('Y-m-d'))
            ->where('time', '<=', $now->startOfMinute()->format('H:m:s'))
            ->where('status', '<>', Reminder::STATUS_COMPLETED)
            ->where('author_id', '=', $currentUser->id)
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
        $before = $now->subDays($numberOfDays);
        return Reminder::where('date', '<=', $before)->get();

    }

}
