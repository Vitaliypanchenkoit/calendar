<?php

namespace App\Services\LoggerChainService;

use App\Helpers\ErrorHelper;
use Illuminate\Support\Facades\Log;

class FileLogger extends AbstractLogger
{
    public function handle(\Throwable $e)
    {
        Log::error(ErrorHelper::getErrorInfo($e));

        parent::handle($e);
    }

}
