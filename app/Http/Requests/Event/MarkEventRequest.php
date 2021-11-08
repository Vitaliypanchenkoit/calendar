<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class MarkEventRequest extends FormRequest
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
        return [
            'id' => ['required', 'exists:events,id'],
            'key' => ['required', 'in:take_part,not_interesting'],
            'value' => ['required', 'boolean'],
        ];
    }
}
