<?php

namespace App\PersistModule;

use App\Models\Event;
use App\Models\User;
//use App\Services\ObserverService\Observers\NotifyParticipant;
//use App\Services\ObserverService\Subjects\CreateUpdateEvent;
use App\Events\CreateUpdateEvent;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\Collection;

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

        if ($users) {
            $event->participants()->saveMany($users);
        }

        CreateUpdateEvent::dispatch($event);

        /* Clear observer implementation */
//        $subject = new CreateUpdateEvent($event);
//
//        foreach ($users as $user) {
//            $observer = new NotifyParticipant($user);
//            $subject->attach($observer);
//        }
//
//        $subject->notify();
        /* End */

        return Event::where('id', $event->id)->with('participants')->first();
    }

    /**
     * @param array $data
     * @return Event
     */
    public function update(array $data): Event
    {
        $hasChanches = false;
        $repository = new EventRepository();
        $event = $repository->getSingleEvent($data['id']);

        CreateUpdateEvent::dispatch($event);
        return $event;

        $existingParticipants = $event->participants()->keyBy('email')->keys()->toArray();

        if ($existingParticipants !== $data['participants']) {
            $users = $data['participants'] ? $this->saveParticipants($data['participants'])->keyBy('id')->keys()->toArray() : [];
            $event->participants()->sync($users);
            $hasChanches = true;
        }

        if ($hasChanches ||
            $event->title !== $data['title'] ||
            $event->content !== $data['content'] ||
            $event->date !== $data['date'] ||
            $event->time !== $data['time']
        ) {
            CreateUpdateEvent::dispatch($event);
        }

        $event->title = $data['title'];
        $event->content = $data['content'];
        $event->date = $data['date'];
        $event->time = $data['time'];
        $event->save();

        return $event;

    }

    /**
     * @param array $participants
     * @return Collection|void
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
