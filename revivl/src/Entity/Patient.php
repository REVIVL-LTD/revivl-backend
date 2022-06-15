<?php

namespace App\Entity;

use App\Entity\Traits\FioTrait;
use App\Entity\Traits\SexTrait;
use App\Helper\Enum\Role;
use App\Repository\PatientRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\Table(name: 'patient')]
class Patient extends AbstractUser
{
    use FioTrait;
    use SexTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private $phone;

    #[ORM\Column(type: 'date')]
    private $birthday;

    #[ORM\ManyToMany(targetEntity: Promo::class, mappedBy: 'users')]
    private $promos;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'users')]
    private $address;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: CourseUser::class)]
    private $courses;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: CodeAuth::class)]
    private $codes;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Order::class)]
    private $orders;

    public function __construct()
    {
        parent::__construct();
        $this->addPatientRole();
        $this->promos = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->codes = new ArrayCollection();
        $this->orders = new ArrayCollection();
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
     * @return Collection<int, Promo>
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(?Promo $promo): self
    {
        if ($promo &&!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addUser($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeUser($this);
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
     * @return Collection<int, CourseUser>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(CourseUser $course): self
    {

        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setPatient($this);
        }

        return $this;
    }

    public function removeCourse(CourseUser $course): self
    {
        if ($this->courses->removeElement($course)) {
            if ($course->getPatient() === $this) {
                $course->setPatient(null);
            }
        }

        return $this;
    }

    public function getBirthday(): DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(DateTime $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection<int, CodeAuth>
     */
    public function getCodeAuth(): Collection
    {
        return $this->codes;
    }

    public function addCodeAuth(CodeAuth $code): self
    {
        if (!$this->codes->contains($code)) {
            $this->codes[] = $code;
            $code->setPatient($this);
        }

        return $this;
    }

    public function removeCodeAuth(CodeAuth $code): self
    {
        if ($this->codes->removeElement($code)) {
            // set the owning side to null (unless already changed)
            if ($code->getPatient() === $this) {
                $code->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setPatient($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPatient() === $this) {
                $order->setPatient(null);
            }
        }

        return $this;
    }
}
