<?php

namespace App\Entity;

use App\Helper\Status\AbstractStatus;
use App\Helper\Status\StatusTrait;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoRepository::class)]
#[ORM\Table(name: 'promo')]
class Promo
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public readonly int $id;

    #[ORM\Column(type: 'string', length: 255)]
    public readonly string $name;

    #[ORM\ManyToMany(targetEntity: AbstractUser::class, inversedBy: 'promos')]
    private $users;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->setStatus(AbstractStatus::ACTIVE->value);
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection<int, AbstractUser>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(AbstractUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(AbstractUser $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
