<?php

namespace App\Services\LoggerChainService;

use Illuminate\Support\Facades\Log;

class FileLogger extends AbstractLogger
{
    public function handle(\Throwable $e)
    {
        $error = 'ERROR CODE: ';
        $error .= is_numeric($e->getCode()) ? $e->getCode() : 500;
        $error .= PHP_EOL;
        $error .= '. ERROR MESSAGE: ' . $e->getMessage();
        $error .= PHP_EOL;
        $error .= '. OCCURRED IN ' . $e->getFile() . ' LINE ' . $e->getLine();

        Log::error($error);

        return parent::handle($e);
    }

}
