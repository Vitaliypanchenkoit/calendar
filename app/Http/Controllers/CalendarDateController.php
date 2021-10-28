<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteObjectRequest;
use App\Http\Requests\GetDateDataRequest;
use App\Http\Requests\GetMonthDataRequest;
use App\Repositories\ReminderRepository;
use App\Services\CalendarProxyService\CachingData;
use App\Services\CalendarService;
use App\Services\LoggerChainService\Logger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarDateController extends Controller
{
    /**
     * CalendarDateController constructor.
     * @param CachingData $calendarDataService
     */
    public function __construct(private CachingData $calendarDataService)
    {
    }

    /**
     * Get data of the certain month
     * @param GetMonthDataRequest $request
     * @return JsonResponse
     */
    public function getMonthData(GetMonthDataRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = [
            'dates' => [],
            'news' => [],
            'events' => [],
            'reminders' => [],
            'remindersForToday' => []
        ];

        try {
            $daysInMonth = Carbon::create($data['year'] . '-' . $data['month'] . '-1')->daysInMonth;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = Carbon::create($data['year'] . '-' . $data['month'] . '-' . $i);

                $result['dates'][] = $i;
                $records = $this->calendarDataService->getDayData($date->format('Y-m-d'));
                $result['events'][$i] = $records['events'];
                $result['news'][$i] = $records['news'];
                $result['reminders'][$i] = $records['reminders'];
            }

            $repository = new ReminderRepository();
            $remindersForToday = $repository->getRemindersForToday();
            $result['remindersForToday'] = $remindersForToday;
        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return response()->json($result, 200);
    }

    /**
     * Get data of the certain date
     * @param GetDateDataRequest $request
     * @return JsonResponse
     */
    public function getDateData(GetDateDataRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = [
            'news' => [],
            'events' => [],
            'reminders' => [],
        ];

        try {
            $date = Carbon::create($data['year'] . '-' . $data['month'] . '-' . $data['date']);
            $records = $this->calendarDataService->getDayData($date->format('Y-m-d'));
            $result['events'] = $records['events'];
            $result['news'] = $records['news'];
            $result['reminders'] = $records['reminders'];
        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return response()->json($result, 200);
    }

    /**
     * Delete an Object
     * @param DeleteObjectRequest $request
     * @return JsonResponse
     */
    public function deleteObject(DeleteObjectRequest $request)
    {
        $data = $request->validated();

        try {
            $service = new CalendarService();
            $service->deleteObject($data['objectName'], $data['id']);

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return response()->json(true, 200);

    }
}
