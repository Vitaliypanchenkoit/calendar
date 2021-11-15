<?php

namespace App\Repositories\Interfaces;

interface OptionRepositoryInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function getOptionByKey(string $key);

}
