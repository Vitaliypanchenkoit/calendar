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
     * @throws \Exception
     */
    public function holdReminder(int $id, int $period)
    {
        $reminder = Reminder::find($id);

        if ($reminder->author_id !== auth()->user()->id) {
            throw new \Exception(__('You haven\'t an access to hold this reminder'), 403);
        }

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
     * @throws \Exception
     */
    public function updateStatus(int $id, string $status)
    {
        $reminder = Reminder::find($id);
        if ($reminder->author_id !== auth()->user()->id) {
            throw new \Exception(__('You haven\'t an access to update this reminder'), 403);
        }
        $reminder->status = $status;
        $reminder->save();

        return $reminder;
    }

}
