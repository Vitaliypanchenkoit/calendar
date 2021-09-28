<?php


namespace App\Repositories;


use App\Models\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getSingleNews(int $id)
    {
        return News::select(['*'])
            ->with('newsMarks')
            ->first();
    }

    public function getDateNews(string $date): array
    {
        return News::select('news.*', 'users.name as author_name')
            ->join('users', 'users.id', '=', 'news.author_id')
            ->where('news.date', $date)
            ->orderBy('news.time')
            ->get();

    }

}
