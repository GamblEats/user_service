<?php

namespace App\Service;

use App\Document\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function userSetters(array $request): User
    {
        $user = new User();

        if (isset($request["firstName"]) && $request["firstName"] !== "") {
            $user->setFirstName($request["firstName"]);
        }

        if (isset($request["lastName"]) && $request["lastName"] !== "") {
            $user->setLastName($request["lastName"]);
        }

        if (isset($request["email"]) && $request["email"] !== "") {
            $user->setEmail($request["email"]);
        }

        if (isset($request["phone"]) && $request["phone"] !== "") {
            $user->setType($request["phone"]);
        }

        if (isset($request["password"]) && $request["password"] !== "") {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $request["password"]
            );
            $user->setPassword($hashedPassword);
        }

        return $user;
    }

    public function passwordIsValid(User $user,string $password): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $password);
    }
}