<?php

namespace App\Repositories\Interfaces;

interface IventMarkRepositoryInterface
{
    /**
     * @param int $eventId
     * @param int $userId
     * @return mixed
     */
    public function getEventBy(int $eventId, int $userId);

}
