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

        if (isset($request["lastName"]) && $request["lastName"] !== "") {
            $user->setName($request["lastName"]);
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

    public function userEdite(User $user, array $request): User
    {
        if(isset($request["firstName"]) && $request["firstName"] !== $user->getFirstName()) {
            $user->setFirstName($request["firstName"]);
        }

        if(isset($request["lastName"]) && $request["lastName"] !== $user->getLastName()) {
            $user->setLastName($request["lastName"]);
        }

        if(isset($request["email"]) && $request["email"] !== $user->getEmail()) {
            $user->setEmail($request["email"]);
        }

        if(isset($request["password"]) && $request["password"] !== $user->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $request["password"]
            );
            $user->setPassword($hashedPassword);
        }

        if(isset($request["address"]) && $request["address"] !== $user->getAddress()) {
            $user->setAddress($request["address"]);
        }

        if(isset($request["additional"]) && $request["additional"] !== $user->getAdditional()) {
            $user->setAdditional($request["additional"]);
        }

        return $user;
    }

    public function passwordIsValid(User $user,string $password): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function checkRoles(string $role, User $user): bool
    {
        return in_array($role, $user->getType());
    }
}