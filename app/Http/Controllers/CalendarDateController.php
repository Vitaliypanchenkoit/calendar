<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMonthDataRequest;
use App\Models\Event;
use App\Models\News;
use App\Models\Reminder;
use App\Repositories\CalendarRepository;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarDateController extends Controller
{
    /**
     * @var CalendarRepository
     */
    private CalendarRepository $calendarRepository;

    /**
     * CalendarDateController constructor.
     * @param CalendarRepository $calendarRepository
     */
    public function __construct(CalendarRepository $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;

    }

    /**
     * @param GetMonthDataRequest $request
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

        $daysInMonth = Carbon::create($data['year'] . '-' . $data['month'] . '-1')->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::create($data['year'] . '-' . $data['month'] . '-' . $i);

            $result['dates'][] = $i;
            $result['news'][$i] = $this->calendarRepository->getDateObjects(News::class, $date->format('Y-m-d'));
            $result['events'][$i] = $this->calendarRepository->getDateObjects(Event::class, $date->format('Y-m-d'));
            $result['reminders'][$i] = $this->calendarRepository->getDateObjects(Reminder::class, $date->format('Y-m-d'));
        }

        return response()->json($result, 200);
    }
}
