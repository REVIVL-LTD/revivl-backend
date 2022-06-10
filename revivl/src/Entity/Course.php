<?php

namespace App\Entity;

use App\Entity\Traits\PhotoTrait;
use App\Helper\Status\StatusTrait;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\Table(name: 'course')]
class Course
{
    use PhotoTrait;
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public readonly int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Length(max:10)]
    private $abbreviation;

    #[ORM\Column(type: 'integer')]
    private $cost;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'courses')]
    private $doctor;

    #[ORM\OneToMany(mappedBy: 'courses', targetEntity: CourseUser::class)]
    private $patients;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $index): self
    {
        $this->name = $index;

        return $this;
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * @return Collection<int, CourseUser>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(CourseUser $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setCourse($this);
        }

        return $this;
    }

    public function removePatient(CourseUser $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            if ($patient->getCourse() === $this) {
                $patient->setCourse(null);
            }
        }

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation($abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }
}
