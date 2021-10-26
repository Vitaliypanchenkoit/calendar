<?php

namespace App\Services\LoggerChainService;

interface LoggerInterface
{
    public function setNext(LoggerInterface $logger): LoggerInterface;

    public function handle(\Throwable $e);

}
