<?php

namespace App\Entity;

use App\Entity\Traits\FioTrait;
use App\Entity\Traits\SexTrait;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Role;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\Table(name: 'patient')]
class Patient extends AbstractUser
{
    use FioTrait;
    use SexTrait;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $phone;

    #[ORM\ManyToMany(targetEntity: Promocode::class, mappedBy: 'users')]
    private $promocodes;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'users')]
    private $address;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'courses')]
    private $courses;

    public function __construct()
    {
        parent::__construct();
        $this->addPatientRole();
        $this->promocodes = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    public function isPatient(): bool
    {
        return  in_array(Role::ROLE_PATIENT->value, $this->getRoles());
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Promocode>
     */
    public function getPromocodes(): Collection
    {
        return $this->promocodes;
    }

    public function addPromocode(Promocode $promocode): self
    {
        if (!$this->promocodes->contains($promocode)) {
            $this->promocodes[] = $promocode;
            $promocode->addUser($this);
        }

        return $this;
    }

    public function removePromocode(Promocode $promocode): self
    {
        if ($this->promocodes->removeElement($promocode)) {
            $promocode->removeUser($this);
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->addPatient($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            $course->removePatient($this);
        }

        return $this;
    }
}
