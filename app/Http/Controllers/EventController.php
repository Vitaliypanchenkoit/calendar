<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\MarkEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Requests\Event\ValidateEventIdRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventMark;
use App\PersistModule\PersistEvent;
use App\Repositories\EventMarkRepository;
use App\Repositories\EventRepository;
use App\Services\EventService;
use App\Services\LoggerChainService\Logger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

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
            $data['participants'] = !empty($data['participants']) ? json_decode($data['participants']) : [];

            if (is_null($data['participants'])) {
                throw new \Exception(__('Invalid list of participants'), 422);
            }

            $persistModule = new PersistEvent();
            $event = $persistModule->create($data);

            CacheHelper::createOrUpdateRecord(CacheHelper::EVENTS, $data['date'], $event);

            return new EventResource($event);

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
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

            $data['participants'] = !empty($data['participants']) ? json_decode($data['participants']) : [];

            if (is_null($data['participants'])) {
                throw new \Exception(__('Invalid list of participants'), 422);
            }

            $event = Event::find($data['id']);
            if ($event->author_id !== auth()->user()->id) {
                throw new \Exception(__('You haven\'t an access to update this event'), 403);
            }

            $persistModule = new PersistEvent();
            $event = $persistModule->update($data);

            CacheHelper::createOrUpdateRecord(CacheHelper::EVENTS, $data['date'], $event);

            return new EventResource($event);

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }

    /**
     * Mark the event
     * @param MarkEventRequest $request
     * @return \Illuminate\Http\JsonResponse|EventResource
     */
    public function mark(MarkEventRequest $request)
    {
        try {
            $data = $request->validated();
            $service = new EventService();
            $event = $service->markEvent($data['id'], $data['key'], $data['value']);
            return new EventResource($event);

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

    }
}
