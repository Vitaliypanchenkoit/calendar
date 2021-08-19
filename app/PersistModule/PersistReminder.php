<?php

namespace App\PersistModule;

use App\Models\Reminder;

class PersistReminder implements PersistInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Reminder::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'date' => $data['date'],
            'time' => $data['time'],
            'author_id' => auth()->user()->id,
        ]);
    }

    public function update(array $data)
    {
        return Reminder::where(['id' => $data['id']])
            ->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'date' => $data['date'],
                'time' => $data['time'],
            ]);

    }

}
