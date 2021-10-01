<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class MarkNewsRequest extends FormRequest
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
            'newsId' => ['required', 'exists:news,id'],
            'key' => ['required', 'string', 'in:read,important'],
            'value' => ['required', 'boolean'],
        ];
    }
}
