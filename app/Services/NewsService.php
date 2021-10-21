<?php

namespace App\Services;

use App\Helpers\CacheHelper;
use App\Helpers\NewsHelper;
use App\Models\NewsMark;
use App\Notifications\NewsWasMarkAsImportant;
use App\Repositories\NewsMarkRepository;
use App\Repositories\NewsRepository;

class NewsService
{
    /**
     * @param $newsId
     * @param $key
     * @param $value
     */
    public function markNews($newsId, $key, $value)
    {
        $user = auth()->user();

        /* Create or update news mark */
        $repository = new NewsMarkRepository();
        $newsMark = $repository->getNewsMarkByUserAndNewsIds($newsId, $user->id);
        if (!$newsMark) {
            $newsMark = NewsMark::create([
                'news_id' => $newsId,
                'user_id' => $user->id,
                $key => $value
            ]);
        } else {
            $newsMark->{$key} = $value;
            $newsMark->save();
        }

        /* Get the news from repository with marks info */
        $newsRepository = new NewsRepository();
        $news = $newsRepository->getSingleNews($newsMark->news_id);

        $news = NewsHelper::reformatNews($news);

        /* Update data in the cache */
        CacheHelper::createOrUpdateRecord(CacheHelper::NEWS, $news->date, $news);

        /* Send notification to the author of news */
        if ($key === 'important' &&
            $value
        ) {
            $news->author->notify(new NewsWasMarkAsImportant($news, $user));
        }

    }

}
