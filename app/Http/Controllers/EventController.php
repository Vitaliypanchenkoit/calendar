<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Requests\ValidateEventIdRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\PersistModule\PersistEvent;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create(CreateEventRequest $request): mixed
    {
        try {
            $data = $request->validated();

            $date = new Carbon($data['date']);
            $time = new Carbon($data['time']);
            $data['date'] = $date->format('Y-m-d');
            $data['time'] = $time->format('H:i');
            $data['participants'] = $data['participants'] ? json_decode($data['participants']) : [];

            $persistModule = new PersistEvent();
            $event = $persistModule->create($data);

            $event->participants = $event->participants->keyBy('id');
            $event->unsetRelation('participants');

            CacheHelper::createOrUpdateRecord(CacheHelper::EVENTS, $data['date'], $event);

            return new EventResource($event);

        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }

    /**
     * @param ValidateEventIdRequest $request
     * @return mixed
     */
    public function edit(ValidateEventIdRequest $request)
    {
        $data = $request->validated();

        $repository = new EventRepository();
        return $repository->getSingleEvent($data['id']);
    }

    /**
     * @param UpdateEventRequest $request
     * @return \Illuminate\Http\JsonResponse|EventResource
     */
    public function update(UpdateEventRequest $request)
    {
        try {
            $data = $request->validated();
            $dateTime = new Carbon($data['time']);
            $data['time'] = $dateTime->format('H:i');

            $dateTime = new Carbon($data['date']);
            $data['date'] = $dateTime->format('Y-m-d');

            $data['participants'] = $data['participants'] ? json_decode($data['participants']) : [];

            $event = Event::find($data['id']);
            if ($event->author_id !== auth()->user()->id) {
                throw new \Exception(__('You haven\'t an access to update this event'));
            }

            $persistModule = new PersistEvent();
            $event = $persistModule->update($data);

            CacheHelper::createOrUpdateRecord(CacheHelper::EVENTS, $data['date'], $event);

            return new EventResource($event);

        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }

    public function acceptInvitation(string $data)
    {
        $decodedData = json_decode(base64_decode($data));

    }
}
