<?php

namespace App\Services\LoggerChainService;

abstract class AbstractLogger implements LoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $next;

    public function setNext(LoggerInterface $logger): LoggerInterface
    {
        $this->next = $logger;
        return $logger;

    }

    /**
     * @param \Throwable $e
     * @return void
     */
    public function handle(\Throwable $e)
    {
        if (isset($this->next)) {
            $this->next->handle($e);
        }
    }


}
