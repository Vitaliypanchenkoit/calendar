<?php


namespace App\Repositories\Interfaces;


interface ReminderRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getRemindersForNow();

    /**
     * @return mixed
     */
    public function getRemindersForToday();

}
