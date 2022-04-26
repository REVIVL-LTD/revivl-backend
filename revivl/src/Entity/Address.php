<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $index;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $flat;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'addresses')]
    private $city;

    #[ORM\ManyToOne(targetEntity: House::class, inversedBy: 'houses')]
    private $streetHouse;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: User::class)]
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIndex(): ?string
    {
        return $this->index;
    }

    public function setIndex(string $index): self
    {
        $this->index = $index;

        return $this;
    }

    public function getFlat(): ?string
    {
        return $this->flat;
    }

    public function setFlat(string $flat): self
    {
        $this->flat = $flat;

        return $this;
    }

    public function getStreetHouse(): House
    {
        return $this->streetHouse;
    }

    public function setStreetHouse(House $streetHouse): self
    {
        $this->streetHouse = $streetHouse;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAdress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAdress() === $this) {
                $user->setAdress(null);
            }
        }

        return $this;
    }
}
