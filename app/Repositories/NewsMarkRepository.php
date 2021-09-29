<?php

namespace App\Repositories;

use App\Models\NewsMark;
use App\Repositories\Interfaces\NewsMarkRepositoryInterface;

class NewsMarkRepository implements NewsMarkRepositoryInterface
{
    /**
     * @param int $newsId
     * @param int $userId
     * @return mixed
     */
    public function getNewsMarkByUserAndNewsIds(int $newsId, int $userId): mixed
    {
        return NewsMark::where(['news_id' => $newsId, 'user_id' => $userId])->first();
    }

}
