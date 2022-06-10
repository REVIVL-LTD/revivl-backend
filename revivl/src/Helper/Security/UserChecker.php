<?php


namespace App\Helper\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        // TODO: Implement checkPreAuth() method.
    }

    public function checkPostAuth(UserInterface $user)
    {
        self::checkUser($user);
    }


    public static function checkUser(UserInterface $user): bool
    {
        switch(true){
            case $user->isNew():
                throw new CustomUserMessageAuthenticationException(
                    'Please confirm your email!'
                );
            case $user->isWithoutPassword():
                throw new CustomUserMessageAuthenticationException(
                    'Please set or change your password!'
                );
            case $user->isArchiveUser():
                throw new CustomUserMessageAuthenticationException(
                    'Your user is blocked!'
                );
            case $user->isActiveUser():
            default:
                return true;
        }
    }
}