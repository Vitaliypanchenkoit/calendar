<?php

namespace App\Http\Requests\Event;

use App\Rules\FutureOrCurrentDate;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $time = '';
        if (isset(request()->time)) {
            $time = new Carbon(request()->time);
            $time = $time->format('H:i');
        }

        return [
            'title' => ['required'],
            'content' => ['required'],
            'date' => ['required', 'date', new FutureOrCurrentDate($time)],
            'time' => ['required', 'date'],
            'participants' => ['nullable', 'string'],
        ];
    }
}
