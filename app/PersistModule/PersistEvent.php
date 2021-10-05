<?php

namespace App\PersistModule;

use App\Models\Event;

class PersistEvent implements PersistInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Event::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'date' => $data['date'],
            'time' => $data['time'],
            'author_id' => auth()->user()->id,
        ]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data)
    {
        return Event::where(['id' => $data['id']])
            ->update([
                'time' => $data['time'],
            ]);

    }

}
