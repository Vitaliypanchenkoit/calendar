<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reminder\CreateReminderRequest;
use App\Http\Requests\ValidateReminderIdRequest;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use App\PersistModule\PersistReminder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * @param ValidateReminderIdRequest $request
     * @return mixed
     */
    public function create(CreateReminderRequest $request): mixed
    {
        try {
            $data = $request->validated();

            $dateTime = new Carbon($data['dateTime']);
            $data['date'] = $dateTime->format('Y-m-d');
            $data['time'] = $dateTime->format('H:i');

            $persistModule = new PersistReminder();
            $reminder = $persistModule->create($data);
            return new ReminderResource($reminder);

        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }

    /**
     * @param ValidateReminderIdRequest $request
     * @return mixed
     */
    public function edit(ValidateReminderIdRequest $request): mixed
    {
        $data = $request->validated();

        return Reminder::find($data['id']);
    }
}
