<?php

namespace App\Services\LoggerChainService;

class EmailLogger extends AbstractLogger
{
    public function handle(\Throwable $e)
    {
        $a = 1;
        return parent::handle($e);

    }

}
