<?php

namespace App\Helpers;

class ErrorHelper
{
    /**
     * @param \Throwable $e
     * @return string
     */
    public static function getErrorInfo(\Throwable $e): string
    {
        $error = 'ERROR CODE: ';
        $error .= is_numeric($e->getCode()) ? $e->getCode() : 500;
        $error .= PHP_EOL;
        $error .= '. ERROR MESSAGE: ' . $e->getMessage();
        $error .= PHP_EOL;
        $error .= '. OCCURRED IN ' . $e->getFile() . ' LINE ' . $e->getLine();
        return $error;

    }

}
