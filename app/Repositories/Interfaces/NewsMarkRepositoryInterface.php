<?php

namespace App\Repositories\Interfaces;

interface NewsMarkRepositoryInterface
{
    /**
     * @param int $newsId
     * @param int $userId
     * @return mixed
     */
    public function getNewsMarkByUserAndNewsIds(int $newsId, int $userId): mixed;

}
