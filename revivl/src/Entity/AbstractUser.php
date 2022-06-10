<?php

namespace App\Entity;

use App\Helper\Enum\Role;
use App\Helper\Status\AbstractStatus;
use App\Helper\Status\AbstractUserStatus;
use App\Helper\Status\StatusTrait;
use App\Helper\Status\UserStatus;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: 'type', type: "integer")]
#[ORM\DiscriminatorMap([1 => 'Patient', 2 => 'Doctor', 3 => 'Admin' ])]
#[UniqueEntity(fields: ["email"], message: 'There is already an account with this email', entityClass: "App\Entity\AbstractUser", repositoryMethod: "findByUniqueCriteria")]
abstract class AbstractUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public readonly int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string', nullable: true)]
    private $password;

    public function __construct()
    {
        $this->status = AbstractStatus::ACTIVE->value;
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

        $this->setStatus(UserStatus::ACTIVE->value);

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

    public function isDoctor(): bool
    {
        return in_array(Role::ROLE_DOCTOR->value, $this->getRoles(), true);
    }

    public function isAdmin(): bool
    {
        return in_array(Role::ROLE_ADMIN->value, $this->getRoles(), true);
    }

    public function isPatient(): bool
    {
        return in_array(Role::ROLE_PATIENT->value, $this->getRoles(), true);
    }

    public function isActiveUser(): bool
    {
        return $this->getStatus() == UserStatus::ACTIVE;
    }

    public function isArchiveUser(): bool
    {
        return $this->getStatus() == UserStatus::ARCHIVE;
    }

    public function isWithoutPassword(): bool
    {
        return $this->getStatus() == UserStatus::WITHOUT_PASSWORD;
    }

    public function isNew(): bool
    {
        return $this->getStatus() == UserStatus::NEW;
    }
}
