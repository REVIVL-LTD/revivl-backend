<?php

namespace App\Helper\DTO;

use App\Service\ValidateService;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

class EmailAuthDto
{
    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Assert\Email(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $email;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $name;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $surname;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $postCode;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $city;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $address;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly string $phone;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Groups(["check"])]
    public readonly null|string $promocode;

    #[Assert\Callback([ValidateService::class, 'validateInt'], groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    public readonly int $course;

    #[Assert\Type(type: "string", groups: ["check"])]
    #[Assert\Callback([ValidateService::class, 'validateDateTime'], groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    private $birthday;

    #[Assert\Callback([ValidateService::class, 'validateBool'], groups: ["check"])]
    #[Assert\NotBlank(groups: ["check"])]
    #[Groups(["check"])]
    private $sex;

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }


    public function setCourse(int $course): void
    {
        $this->course = $course;
    }

    public function setPromocode(?string $promocode): void
    {
        $this->promocode = $promocode;
    }

    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }
    public function getBirthday(): \DateTime
    {
        return new \DateTime($this->birthday);
    }

    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

    public function getSex(): bool
    {
        return filter_var($this->sex, FILTER_VALIDATE_BOOLEAN);
    }
}