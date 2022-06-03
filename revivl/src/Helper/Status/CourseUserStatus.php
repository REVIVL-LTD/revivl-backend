<?php


namespace App\Helper\Status;


enum CourseUserStatus: int
{
    case NOT_PAY = 1;
    case OPEN = 10;
    case FINISH = 21;

    public function getName(): string
    {
        return match($this){
            self::NOT_PAY => 'NOT_PAY',
            self::OPEN => 'OPEN',
            self::FINISH => 'FINISH',
        };
    }
}