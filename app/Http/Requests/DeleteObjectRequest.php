<?php

namespace App\Http\Requests;

use App\Helpers\ObjectHelper;
use Illuminate\Foundation\Http\FormRequest;

class DeleteObjectRequest extends FormRequest
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
        $objectName = request()->get('objectName');
        $dbTable = '';
        if ($objectName) {
            $dbTable = ObjectHelper::getDbTableName($objectName);
        }
        return [
            'objectName' => ['required', 'string', 'in:Reminder,Event,News'],
            'id' => ['required', 'integer', 'exists:' . $dbTable . ',id'],
        ];
    }
}
