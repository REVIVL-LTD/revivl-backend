<?php

namespace App\Helper\DTO;

class ResponseData
{
    public function __construct(public readonly mixed $body, public readonly mixed $queries)
    {
    }
}