<?php

namespace App\Entity;

use App\Helper\Status\StatusTrait;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public readonly int $id;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'order')]
    public Patient $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
