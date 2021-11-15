<?php

namespace App\Repositories;

use App\Models\Option;
use App\Repositories\Interfaces\OptionRepositoryInterface;

class OptionRepository implements OptionRepositoryInterface
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
