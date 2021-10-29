<?php


namespace App\Repositories\Interfaces;


interface NewsRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getSingleNews(int $id);

    /**
     * @param string $date
     * @return mixed
     */
    public function getDateNews(string $date);

}
