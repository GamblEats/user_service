<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(collection="users")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Object Property
     */

    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Order::class, mappedBy="client")
     */
    protected ArrayCollection $orders;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Notification::class, mappedBy="user")
     */
    protected ArrayCollection $notifications;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Order::class, mappedBy="deliverer")
     */
    protected ArrayCollection $ordersToDeliver;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $firstName = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $lastName = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $email = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $password;

    /**
     * @MongoDB\Field(type="raw")
     */
    protected $type;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $address = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $additional = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $city = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $postalCode = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $phone = null;

    /**
     * @MongoDB\Field(type="raw")
     */
    protected $referral;

    /**
     * @MongoDB\Field(type="string")
     */
    protected mixed $codeRef = null;

    /**
     * @MongoDB\Field(type="bool")
     */
    protected bool $isDeployed = false;

    /**
     * Mapping Property
     */

    public function getId(): mixed
    {
        return $this->_id;
    }

    public function setId(mixed $id): void
    {
        $this->_id = $id;
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
        $notificationsArray = [];
        foreach ($this->getNotifications() as $notification) {
            $notificationsArray[] = $notification->toArray();
        }

        return [
            'id' => $this->getId(),
            'lastName' => $this->getLastName(),
            'firstName' => $this->getFirstName(),
            'mail' => $this->getEmail(),
            'address' => $this->getAddress(),
            'additional' => $this->getAdditional(),
            'referralCount' => count($this->getReferral()),
            'codeRef' => $this->getCodeRef(),
            'city' => $this->getCity(),
            'postalCode' => $this->getPostalCode(),
            'isDeployed' => $this->getIsDeployed(),
            'type' => $this->getType(),
            'phone' => $this->getPhone(),
            'notifications' => $notificationsArray
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
        $types = [];
        foreach ($this->type as $key => $type) {
            $types[] = $key;
        }
        return $types;
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

    /**
     * @return ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection $orders
     */
    public function setOrders(ArrayCollection $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrdersToDeliver(): ArrayCollection
    {
        return $this->ordersToDeliver;
    }

    /**
     * @param ArrayCollection $ordersToDeliver
     */
    public function setOrdersToDeliver(ArrayCollection $ordersToDeliver): void
    {
        $this->ordersToDeliver = $ordersToDeliver;
    }

    /**
     * @return mixed|null
     */
    public function getFirstName(): mixed
    {
        return $this->firstName;
    }

    /**
     * @param mixed|null $firstName
     */
    public function setFirstName(mixed $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed|null
     */
    public function getLastName(): mixed
    {
        return $this->lastName;
    }

    /**
     * @param mixed|null $lastName
     */
    public function setLastName(mixed $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getReferral()
    {
        $referrals = [];
        if ($this->referral) {
            foreach ($this->referral as $key => $type) {
                $referrals[] = $key;
            }
        }
        return $referrals;
    }

    /**
     * @param mixed $referral
     */
    public function setReferral($referral): void
    {
        $this->referral = $referral;
    }

    /**
     * @return mixed|null
     */
    public function getCodeRef(): mixed
    {
        return $this->codeRef;
    }

    /**
     * @param mixed|null $codeRef
     */
    public function setCodeRef(mixed $codeRef): void
    {
        $this->codeRef = $codeRef;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }


    /**
     * @return bool
     */
    public function getIsDeployed(): bool
    {
        return $this->isDeployed;
    }

    /**
     * @param bool $isDeployed
     */
    public function setIsDeployed(bool $isDeployed): void
    {
        $this->isDeployed = $isDeployed;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return ArrayCollection
     */
    public function getNotifications(): ArrayCollection
    {
        return $this->notifications;
    }

    /**
     * @param ArrayCollection $notifications
     */
    public function setNotifications(ArrayCollection $notifications): void
    {
        $this->notifications = $notifications;
    }
}