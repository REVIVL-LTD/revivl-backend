<?php

namespace App\Entity;

use App\Helper\Status\PromoStatus;
use App\Helper\Status\StatusTrait;
use App\Repository\PromoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoRepository::class)]
class Promo
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(targetEntity: Promocode::class, mappedBy: 'promo')]
    private $promocodes;

    public function __construct()
    {
        $this->status = PromoStatus::ACTIVE->value;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatusName(): string
    {
        return  PromoStatus::from($this->getStatus())->getName();
    }
}
