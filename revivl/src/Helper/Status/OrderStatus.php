<?php


namespace App\Helper\Status;


enum OrderStatus: int
{
    case NEW = 1;
    case SUCCESS = 10;
    case ERROR = 21;

    public function getName(): string
    {
        return match($this){
            self::NEW => 'NEW',
            self::SUCCESS => 'SUCCESS',
            self::ERROR => 'ERROR',
        };
    }
}