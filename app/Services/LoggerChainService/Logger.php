<?php

namespace App\Services\LoggerChainService;

class Logger
{
    /**
     * @var AbstractLogger
     */
    private AbstractLogger $logger;

    /**
     * @param \Throwable $e
     */
    public function __construct(private \Throwable $e)
    {
    }

    /**
     * Add all loggers into the chain
     */
    private function makeChain()
    {
        $this->logger = new EmailLogger();
        $this->logger->setNext(new FileLogger());
    }

    /**
     * Log an error
     */
    public function log()
    {
        $this->makeChain();
        $this->logger->handle($this->e);
    }

}
