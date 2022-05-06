<?php

namespace App\Entity;

use App\Helper\Status\AbstractStatus;
use App\Helper\Status\StatusTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: 'admin')]
class Admin extends AbstractUser
{
    public function __construct()
    {
        parent::__construct();
        $this->addAdminRole();
    }

    public function isAdmin(): bool
    {
        return  in_array(Role::ROLE_ADMIN->value, $this->getRoles());
    }
}
