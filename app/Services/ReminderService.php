<?php

namespace App\Services;

use App\Models\Reminder;
use Illuminate\Support\Carbon;

class ReminderService
{
    /**
     * @param int $id
     * @param int $period
     * @return mixed
     */
    public function holdReminder(int $id, int $period)
    {
        $reminder = Reminder::find($id);

        $hold = Carbon::createFromFormat('H:i:s', $reminder->time_hold);
        $hold = $hold->addMinutes($period);

        $reminder->time_hold = $hold->format('H:i:s');
        $reminder->save();

        return $reminder;
    }

    /**
     * @param int $id
     * @param string $status
     * @return mixed
     */
    public function updateStatus(int $id, string $status)
    {
        $reminder = Reminder::find($id);
        $reminder->status = $status;
        $reminder->save();

        return $reminder;
    }

}
