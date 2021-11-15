<?php


namespace App\Repositories;


use App\Helpers\NewsHelper;
use App\Models\News;
use App\Models\NewsMark;
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
        $news = News::select(['*'])
            ->where('id', $id)
            ->with('newsMarks')
            ->first();

        if ($news) {
            $news = NewsHelper::reformatNews($news);
        }

        return $news;
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
        $before = $now->subDays($numberOfDays)->format('Y-m-d');

        $allNews = News::select('id')
            ->where('date', '<=', $before)
            ->get();

        if (!$allNews->count()) {
            return $allNews;
        }

        $ids = $allNews->keyBy('id')->keys();

        $importantNews = NewsMark::select('news_id')
            ->whereIn('news_id', $ids)
            ->where('important', '=', 1)
            ->get();

        if (!$importantNews->count()) {
            return $allNews;
        }

        /* Return only news that weren't marked as important */
        return $allNews->whereNotIn('id', $ids);

    }

}
