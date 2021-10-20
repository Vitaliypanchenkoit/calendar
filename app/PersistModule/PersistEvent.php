<?php

namespace App\PersistModule;

use App\Models\Event;
use App\Models\User;
use App\Sevices\ObserverService\Observers\NotifyParticipant;
use App\Sevices\ObserverService\Subjects\CreateUpdateEvent;

class PersistEvent implements PersistInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $users = $this->saveParticipants($data['participants']);

        $event = Event::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'date' => $data['date'],
            'time' => $data['time'],
            'author_id' => auth()->user()->id,
        ]);

        $event->participants()->saveMany($users);

        $subject = new CreateUpdateEvent($event);

        foreach ($users as $user) {
            $observer = new NotifyParticipant($user);
            $subject->attach($observer);
        }

        $subject->notify();

        return Event::where('id', $event->id)->with('participants')->first();
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

    /**
     * @param array $participants
     * @return array|void
     */
    private function saveParticipants(array $participants)
    {
        if (!$participants) {
            return;
        }

        $users = User::whereIn('email', $participants)->get();

        $existingEmails = $users->keyBy('email')->keys()->toArray();

        $newEmails = array_diff($participants, $existingEmails);

        $newUsers = [];

        foreach ($newEmails as $email) {
            $newUsers[] = User::create([
                'email' => $email,
                'role' => User::ROLE_GUEST
            ]);
        }

        return $users->merge($newUsers);

    }

}
