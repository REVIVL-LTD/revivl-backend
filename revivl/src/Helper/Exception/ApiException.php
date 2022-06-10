<?php

namespace App\Helper\Exception;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{

    public function __construct(protected         $statusCode = ResponseApp::HTTP_INTERNAL_SERVER_ERROR,
                                protected         $message = 'Internal Server Error',
                                protected ?string $detail = null,
                                protected array   $validationError = ['query' => [], 'body' => []],
                                protected array   $headers = [],
                                protected ?array  $castom = null
    )
    {
        $this->message = $message ?: (ResponseApp::getStatusName($statusCode) ?? ResponseApp::getStatusName(ResponseApp::HTTP_INTERNAL_SERVER_ERROR));
        parent::__construct(statusCode: $statusCode, message: $message, headers: $headers);
    }

    #[ArrayShape(['errors' => "array"])]
    public function responseBody(): array
    {
        return [
            'errors' => $this->castom ?: [
                'status' => $this->statusCode,
                'message' => $this->message,
                'detail' => $this->detail,
                "validationError" => $this->validationError
            ]
        ];
    }
}
