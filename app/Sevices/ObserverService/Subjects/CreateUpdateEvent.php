<?php

namespace App\Sevices\ObserverService\Subjects;

use App\Models\Event;

class CreateUpdateEvent implements \SplSubject
{
    public function __construct(public Event $event, protected array $observers = []) {

    }

    /**
     * Add an observer
     * @param \SplObserver $observer
     * @return CreateUpdateEvent
     */
    public function attach(\SplObserver $observer)
    {
        $key = spl_object_hash($observer);
        $this->observers[$key] = $observer;
        return $this;
    }
    /**
     * Remove an observer from $this->observers
     * @param \SplObserver $observer
     */
    public function detach(\SplObserver $observer)
    {
        $key = spl_object_hash($observer);
        unset($this->observers[$key]);
    }
    /**
     * Go through all of the $this->observers and fire the ->update() method.
     *
     * (In Laravel and other frameworks this would often be called the ->handle() method.)
     *
     * @return mixed
     */
    public function notify()
    {
        /** @var \SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

}
