<?php

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document(collection="orders", repositoryClass="App\Repository\OrderRepository")
*/
class Order
{
    const StatusArray = [
        'VALIDATION_PENDING',
        'IN_PREPARATION',
        'READY_FOR_PICKUP',
        'ON_THE_WAY',
        'AT_YOUR_DOOR',
        'DELIVRED',
    ];

    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class, inversedBy="orders", storeAs="id")
     */
    protected User $client;

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class, inversedBy="ordersToDeliver", storeAs="id")
     */
    protected User $deliverer;

    /**
     * @MongoDB\Field(type="string", name="restaurant")
     */
    protected ?string $restaurant = null;

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
     * @MongoDB\Field(type="date")
     */
    protected ?DateTime $deliveryTime = null;

    /**
     * @MongoDB\Field(type="date")
     */
    protected ?DateTime $startTime = null;

    /**
     * @MongoDB\Field(type="date")
     */
    protected ?DateTime $deliveryStartTime = null;

    /**
     * @MongoDB\Field(type="date")
     */
    protected ?DateTime $endTime = null;

    /**
     * @MongoDB\Field(type="collection", type="raw")
     */
    protected $items;

    /**
     * @MongoDB\Field(type="collection", type="raw")
     */
    protected $menus;

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
     * @return DateTime|null
     */
    public function getDeliveryTime(): ?DateTime
    {
        return $this->deliveryTime;
    }

    /**
     * @param DateTime|null $deliveryTime
     */
    public function setDeliveryTime(?DateTime $deliveryTime): void
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
    public function getClient(): User
    {
        return $this->client;
    }

    /**
     * @param User $user
     */
    public function setClient(User $user): void
    {
        $this->client = $user;
    }

    /**
     * @return ?string
     */
    public function getRestaurant(): ?string
    {
        return $this->restaurant;
    }

    /**
     * @param ?string $restaurant
     */
    public function setRestaurant(?string $restaurant): void
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return User
     */
    public function getDeliverer(): User
    {
        return $this->deliverer;
    }

    /**
     * @param User $deliverer
     */
    public function setDeliverer(User $deliverer): void
    {
        $this->deliverer = $deliverer;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * @param mixed $menus
     */
    public function setMenus($menus): void
    {
        $this->menus = $menus;
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveryStartTime(): ?DateTime
    {
        return $this->deliveryStartTime;
    }

    /**
     * @param DateTime|null $deliveryStartTime
     */
    public function setDeliveryStartTime(?DateTime $deliveryStartTime): void
    {
        $this->deliveryStartTime = $deliveryStartTime;
    }
}