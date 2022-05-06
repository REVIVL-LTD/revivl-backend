<?php

namespace App\Entity;

use App\Helper\Status\AbstractStatus;
use App\Helper\Status\StatusTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Role;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Unique;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: 'type', type: "integer")]
#[ORM\DiscriminatorMap([1 => 'Patient', 2 => 'Doctor', 3 => 'Admin' ])]
#[UniqueEntity(fields: "email", entityClass: "App\Entity\AbstractUser", repositoryMethod: "findByUniqueCriteria")]
abstract class AbstractUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    public function __construct()
    {
        $this->status = AbstractStatus::ACTIVE->value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = Role::ROLE_USER->value;

        return array_unique($roles);
    }

    public function addAdminRole()
    {
        if(!in_array(Role::ROLE_ADMIN->value, $this->roles))  $this->roles[] = Role::ROLE_ADMIN->value;
    }

    public function addDoctorRole()
    {
        if(!in_array(Role::ROLE_DOCTOR->value, $this->roles))  $this->roles[] = Role::ROLE_DOCTOR->value;
    }

    public function addPatientRole()
    {
        if(!in_array(Role::ROLE_PATIENT->value, $this->roles))  $this->roles[] = Role::ROLE_PATIENT->value;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
