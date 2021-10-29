<?php


namespace App\Repositories;


use App\Models\News;
use App\Repositories\Interfaces\ClearDataRepositoryInterface;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NewsRepository implements NewsRepositoryInterface, ClearDataRepositoryInterface
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

    /**
     * @return mixed
     */
    public function getOldData(int $numberOfDays)
    {
        $now = now();
        $before = $now->subDays($numberOfDays);

        $importantNews = News::select('news.id')
            ->join('news_marks', 'news.id', '=', 'news_marks.news_id')
            ->where('news.date', '<=', $before)
            ->where('news_marks.important', '=', 1)
            ->get();

        $notImportantNews = News::select('news.id')
            ->join('news_marks', 'news.id', '=', 'news_marks.news_id')
            ->where('news.date', '<=', $before)
            ->where('news_marks.important', '=', 0)
            ->get();

        return $notImportantNews->diff($importantNews);

    }

}
