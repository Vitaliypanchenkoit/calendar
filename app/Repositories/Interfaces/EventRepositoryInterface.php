<?php


namespace App\Repositories\Interfaces;


use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    /**
     * @param int $id
     * @return Event|null
     */
    public function getSingleEvent(int $id): ?Event;

    /**
     * @param string $date
     * @return Collection
     */
    public function getDateEvents(string $date): Collection;

}
