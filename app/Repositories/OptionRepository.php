<?php

namespace App\Repositories;

use App\Models\Option;

class OptionRepository
{
    /**
     * @param string $key
     * @return mixed
     */
    public function getOptionByKey(string $key)
    {
        return Option::where('key', $key)->first();
    }

}
