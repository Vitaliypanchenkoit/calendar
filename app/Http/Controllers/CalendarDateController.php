<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMonthDataRequest;
use App\Repositories\CalendarRepository;
use App\Sevices\CalendarProxyService\CachingData;
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
     * @param GetMonthDataRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMonthData(GetMonthDataRequest $request)
    {
        $data = $request->validated();

        $result = [
            'dates' => [],
            'news' => [],
            'events' => [],
            'reminders' => [],
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
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return response()->json($result, 200);
    }
}
