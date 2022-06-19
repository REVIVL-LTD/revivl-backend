<?php

namespace App\Helper\Status;

enum PromoStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 10;
    case ARCHIVE = 21;

    public function getName(): string
    {
        return match($this){
            self::ACTIVE => 'active',
            self::INACTIVE => 'inactive',
            self::ARCHIVE => 'archive'
        };
    }
}