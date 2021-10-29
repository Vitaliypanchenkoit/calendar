<?php

namespace App\Repositories\Interfaces;

interface ClearDataRepositoryInterface
{
    /**
     * @param int $numberOfDays
     * @return mixed
     */
    public function getOldData(int $numberOfDays);

}
