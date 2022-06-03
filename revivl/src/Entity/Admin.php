<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\Enum\Role;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
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
        return in_array(Role::ROLE_PATIENT->value, $this->getRoles(), true);
    }
}