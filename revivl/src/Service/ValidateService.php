<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateService
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function passwordValid(string $password): void
    {
        if (!$password) throw new RuntimeException('Required  field');

        if (mb_strlen($password) < 8) {
            throw new RuntimeException("Password too short!");
        }

        if (!preg_match("#[0-9]+#", $password)) {
            throw new RuntimeException("Password must include at least one number!");
        }

        if (!preg_match("#[a-zA-Z]+#", $password)) {
            throw new RuntimeException("Password must include at least one letter!");
        }

        if (!preg_match('~[\\\/:*?"\'<>|@]~', $password)) {
            throw new RuntimeException("Password must contain at least one special character!");
        }
    }

    public function emailValid(string $email): void
    {
        if (!$email) throw new RuntimeException('Required  field');

        $emailConstraint = new Email();

        $error = $this->validator->validate(
            $email,
            $emailConstraint
        );
        if (0 !== count($error)) {
            throw new RuntimeException('The value is not email');
        }
    }
}