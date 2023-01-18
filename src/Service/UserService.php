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

    public function userSetters(array $request, string $refCode): User
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

        if (isset($request["role"]) && $request["role"] !== "") {
            $roles[$request["role"]] = true;
            $user->setType($roles);
        }

        if (isset($request["city"]) && $request["city"] !== "") {
            $user->setCity($request["city"]);
        }

        if (isset($request["phone"]) && $request["phone"] !== "") {
            $user->setPhone($request["phone"]);
        }


        if (isset($request["postalCode"]) && $request["postalCode"] !== "") {
            $user->setPostalCode($request["postalCode"]);
        }

        if (isset($request["password"]) && $request["password"] !== "") {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $request["password"]
            );
            $user->setPassword($hashedPassword);
        }

        $user->setCodeRef($refCode);

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

        if (isset($request["city"]) && $request["city"] !== $user->getCity()) {
            $user->setCity($request["city"]);
        }

        if (isset($request["phone"]) && $request["phone"] !== $user->getPhone()) {
            $user->setPhone($request["phone"]);
        }

        if (isset($request["postalCode"]) && $request["postalCode"] !== $user->getPostalCode()) {
            $user->setPostalCode($request["postalCode"]);
        }

        if (isset($request["isDeployed"]) && $request["isDeployed"]) {
            $user->setIsDeployed($request["isDeployed"]);
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