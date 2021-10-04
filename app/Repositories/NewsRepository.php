<?php


namespace App\Repositories;


use App\Models\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getSingleNews(int $id)
    {
        return News::select(['*'])
            ->where('id', $id)
            ->with('newsMarks')
            ->first();
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function getDateNews(string $date)
    {
        return News::select(
            'news.*',
            'users.name as author_name')
            ->join('users', 'users.id', '=', 'news.author_id')
            ->with('newsMarks')
            ->where('news.date', $date)
            ->orderBy('news.time')
            ->get();

    }

}
