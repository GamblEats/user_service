<?php

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document(collection="orders")
 */
class Order
{
    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class, inversedBy="orders", storeAs="id")
     */
    protected User $user;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $deliverer;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $restaurant;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $status = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected ?float $price = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected ?float $deliveryPrice = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $deliveryTime = null;

    /**
     * @MongoDB\Field(type="date")
     */
    protected ?DateTime $startTime = null;

    /**
     * @MongoDB\Field(type="date")
     */
    protected ?DateTime $endTime = null;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->_id = $id;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float|null
     */
    public function getDeliveryPrice(): ?float
    {
        return $this->deliveryPrice;
    }

    /**
     * @param float|null $deliveryPrice
     */
    public function setDeliveryPrice(?float $deliveryPrice): void
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @return string|null
     */
    public function getDeliveryTime(): ?string
    {
        return $this->deliveryTime;
    }

    /**
     * @param string|null $deliveryTime
     */
    public function setDeliveryTime(?string $deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return DateTime|null
     */
    public function getStartTime(): ?DateTime
    {
        return $this->startTime;
    }

    /**
     * @param DateTime|null $startTime
     */
    public function setStartTime(?DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return DateTime|null
     */
    public function getEndTime(): ?DateTime
    {
        return $this->endTime;
    }

    /**
     * @param DateTime|null $endTime
     */
    public function setEndTime(?DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'status' => $this->getStatus(),
            'price' => $this->getPrice(),
            'deliveryPrice' => $this->getDeliveryPrice(),
            'startTime' => $this->getStartTime()?->format('c'),
            'endDate' => $this->getEndTime()?->format('c'),
        ];
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getRestaurant(): string
    {
        return $this->restaurant;
    }

    /**
     * @param string $restaurant
     */
    public function setRestaurant(string $restaurant): void
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return string
     */
    public function getDeliverer(): string
    {
        return $this->deliverer;
    }

    /**
     * @param string $deliverer
     */
    public function setDeliverer(string $deliverer): void
    {
        $this->deliverer = $deliverer;
    }
}