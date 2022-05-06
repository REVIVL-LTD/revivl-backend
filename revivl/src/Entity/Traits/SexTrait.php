<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SexTrait
{
    #[ORM\Column(type: 'boolean')]
    private $sex;

    public function getSex(): bool
    {
        return $this->sex;
    }

    public function setSex(bool $sex): self
    {
        $this->sex = $sex;

        return $this;
    }
}