<?php

namespace App\Repositories\Interfaces;

interface EventMarkRepositoryInterface
{
    /**
     * @param int $eventId
     * @param int $userId
     * @return mixed
     */
    public function getEventBy(int $eventId, int $userId);

}
