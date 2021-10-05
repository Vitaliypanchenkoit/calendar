<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class FutureOrCurrentDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private string $time)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $now = now();
        $value = new Carbon($value);
        $value = $value->format('Y-m-d');

        $date = new Carbon($value . ' ' . $this->time);

        $a = $date->timestamp;

        return $now->timestamp < $date->timestamp;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('You are trying to set past date or time');
    }
}
