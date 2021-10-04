<?php

namespace App\Helpers;

use App\Models\News;

class NewsHelper
{
    /**
     * @param News $news
     * @return News
     */
    public static function reformatNews(News $news)
    {
        $news->read = $news->newsMarks->where('read', 1)->keyBy('user_id')->keys();
        $news->important = $news->newsMarks->where('important', 1)->keyBy('user_id')->keys();
        $news->unsetRelation('newsMarks');
        return $news;
    }

}
