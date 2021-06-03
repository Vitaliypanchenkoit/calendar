<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateEventIdRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @param ValidateEventIdRequest $request
     * @return mixed
     */
    public function edit(ValidateEventIdRequest $request)
    {
        $data = $request->validated();

        return Event::find($data['id']);

    }
}
