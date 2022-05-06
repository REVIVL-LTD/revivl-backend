<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PhotoTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}