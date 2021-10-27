<?php

use App\Models\Reminder;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('reminders.{id}', function ($user, $reminderId) {
    \Illuminate\Support\Facades\Log::debug(123456);
    \Illuminate\Support\Facades\Log::debug($user->id === Reminder::find($reminderId)->author_id);
    return (int) $user->id === Reminder::find($reminderId)->author_id;
});
