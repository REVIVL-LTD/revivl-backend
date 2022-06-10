<?php

namespace App\Helper\DTO;

use App\Service\ValidateService;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CodeAuthDto
{
    #[Assert\Callback([ValidateService::class, 'validateInt'], groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string|int $code;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Assert\Email(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $email;


    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setCode(int|string $code): void
    {
        $this->code = $code;
    }
}