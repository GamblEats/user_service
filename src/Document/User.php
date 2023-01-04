<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Object Property
     */

    /**
     * @MongoDB\Id
     */
    protected mixed $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $name = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $email = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $password;

    /**
     * @MongoDB\Field(type="int")
     */
    protected mixed $type = 1;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $address = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $additional = null;

    /**
     * Mapping Property
     */

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function setName(mixed $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(mixed $email): void
    {
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'mail' => $this->getEmail(),
            'type' => $this->getType(),
            'address' => $this->getAddress(),
            'additional' => $this->getAdditional(),
        ];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(mixed $type): void
    {
        $this->type = $type;
    }

    public function getAddress(): mixed
    {
        return $this->address;
    }

    public function setAddress(mixed $address): void
    {
        $this->address = $address;
    }

    public function getAdditional(): mixed
    {
        return $this->additional;
    }

    public function setAdditional(mixed $additional): void
    {
        $this->additional = $additional;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->getEmail();
    }
}