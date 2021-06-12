<?php

namespace App\Http\Controllers;

use App\Http\Requests\reminder\CreateReminderRequest;
use App\Http\Requests\ValidateReminderIdRequest;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * @param ValidateReminderIdRequest $request
     * @return mixed
     */
    public function create(CreateReminderRequest $request): mixed
    {
        $data = $request->validated();

        return Reminder::find($data['id']);
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
