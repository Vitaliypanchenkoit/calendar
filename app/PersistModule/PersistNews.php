<?php

namespace App\PersistModule;

use App\Models\News;

class PersistNews
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return News::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'date' => $data['date'],
            'time' => $data['time'],
            'author_id' => auth()->user()->id,
        ]);
    }

    public function update(array $data)
    {
        return News::where(['id' => $data['id']])
            ->update([
                'title' => $data['title'],
                'content' => $data['content'],
            ]);

    }

}
