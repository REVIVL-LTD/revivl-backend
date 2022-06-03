<?php

namespace App\Entity;

use App\Repository\CodeAuthRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CodeAuthRepository::class)]
#[ORM\Table(name: 'code_auth')]
class CodeAuth
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public readonly int $id;

    #[Assert\Length(min: 6, max: 6)]
    #[ORM\Column(type: 'integer')]
    public readonly int $code;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'code_auth')]
    private Patient $patient;

    #[ORM\Column(type: 'datetime')]
    public readonly \DateTime $liveTime;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
        $this->code = random_int(100000, 999999);
        $this->liveTime = (new \DateTime())->add(new \DateInterval('PT1H'));
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
