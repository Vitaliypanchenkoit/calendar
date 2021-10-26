<?php

namespace App\Helpers;

class EncryptionHelper
{
    /**
     * @param array $value
     * @return string
     */
    public static function encodeRequestAttribute(array $value): string
    {
        return base64_encode(json_encode($value));
    }

    /**
     * @param string $value
     * @return array
     */
    public static function decodeRequestAttribute(string $value): array
    {
        return json_decode(base64_decode($value), true);
    }

}
