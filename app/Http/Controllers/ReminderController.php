<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Http\Requests\Reminder\CreateReminderRequest;
use App\Http\Requests\Reminder\UpdateReminderRequest;
use App\Http\Requests\Reminder\ValidateReminderIdRequest;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use App\PersistModule\PersistReminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

            $date = new Carbon($data['date']);
            $time = new Carbon($data['time']);
            $data['date'] = $date->format('Y-m-d');
            $data['time'] = $time->format('H:i');

            $persistModule = new PersistReminder();
            $reminder = $persistModule->create($data);

            CacheHelper::createOrUpdateRecord(CacheHelper::REMINDERS, $data['date'], $reminder);

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

    /**
     * @param UpdateReminderRequest $request
     * @return ReminderResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateReminderRequest $request)
    {
        try {
            $data = $request->validated();
            $dateTime = new Carbon($data['time']);
            $data['time'] = $dateTime->format('H:i');

            $dateTime = new Carbon($data['date']);
            $data['date'] = $dateTime->format('Y-m-d');

            $reminder = Reminder::find($data['id']);
            if ($reminder->author_id !== auth()->user()->id) {
                throw new \Exception(__('You haven\'t an access to update this reminder'));
            }

            $persistModule = new PersistReminder();
            $reminder = $persistModule->update($data);

            CacheHelper::createOrUpdateRecord(CacheHelper::REMINDERS, $data['date'], $reminder);

            return new ReminderResource($reminder);

        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }
}
