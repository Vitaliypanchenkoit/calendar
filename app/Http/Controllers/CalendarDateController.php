<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMonthDataRequest;
use Illuminate\Http\Request;

class CalendarDateController extends Controller
{
    /**
     * @param GetMonthDataRequest $request
     */
    public function getMonthData(GetMonthDataRequest $request)
    {
        $data = $request->validated();




    }
}
