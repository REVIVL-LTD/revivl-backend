<?php

namespace App\Helper\Exception;

use Symfony\Component\HttpFoundation\Response;

class ResponseApp extends Response
{
    public const HTTP_INTERNAL_SERVER_ERROR = 460;

    public static function getStatusName(int $code): ?string
    {
        return $code === self::HTTP_INTERNAL_SERVER_ERROR ? 'Internal Server Error' : (self::$statusTexts[$code] ?? null);
    }
}