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
            'news.*', 'users.name as author_name',
            DB::raw('COUNT(news_marks.important) as important,
             COUNT(news_marks.read) as read'))
            ->join('users', 'users.id', '=', 'news.author_id')
            ->leftJoin('news_marks', 'news.id', '=', 'news_marks.news_id')
            ->where('news.date', $date)
            ->orderBy('news.time')
            ->get();

    }

}
