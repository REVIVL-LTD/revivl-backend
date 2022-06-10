<?php


namespace App\Helper\DTO;

use App\Service\ValidateService;
use Symfony\Component\Validator\Constraints as Assert;

class PaginationFilter
{
    public const GROUP = 'pagination';

    #[Assert\Callback([ValidateService::class, 'validateInt'], groups: ["pagination"], )]
    #[Assert\Positive(groups: ["pagination"])]
    protected readonly int $page;

    #[Assert\Callback([ValidateService::class, 'validateInt'], groups: ["pagination"], )]
    #[Assert\Positive(groups: ["pagination"])]
    protected readonly int $size;

    public function __construct()
    {
        $this->page = 1;
        $this->size = 10;
    }


    public function isEmpty(): bool
    {
        return !$this->page and !$this->size;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->size;
    }
}