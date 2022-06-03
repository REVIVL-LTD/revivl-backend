<?php


namespace App\Helper\Status;


enum UserStatus: int
{
    case NEW = 1;
    case WITHOUT_PASSWORD = 7;
    case ACTIVE = 14;
    case ARCHIVE = 21;

    public function getName(): string
    {
        return match($this){
            self::NEW => 'NEW',
            self::WITHOUT_PASSWORD => 'WITHOUT_PASSWORD',
            self::ACTIVE => 'ACTIVE',
            self::ARCHIVE => 'ARCHIVE',
        };
    }
}