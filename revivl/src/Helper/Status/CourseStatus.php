<?php


namespace App\Helper\Status;


enum CourseStatus: int
{
    case ACTIVE = 1;
    case DRAFT = 10;
    case ARCHIVE = 21;

    public function getName(): string
    {
        return match($this){
            self::ACTIVE => 'Active',
            self::DRAFT => 'Draft',
            self::ARCHIVE => 'Archive'
        };
    }
}