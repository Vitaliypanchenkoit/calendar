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

Broadcast::channel('reminder.{id}', function ($user, $reminderId) {
    return (int) $user->id === Reminder::find($reminderId)->author_id;
});
