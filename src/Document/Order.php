<?php

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document(collection="restaurants")
 */
class Order
{
    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * Miss Menus, Client, Restaurant, Deliverer
     */

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
     * @MongoDB\Field(type="Datetime")
     */
    protected ?DateTime $startTime = null;

    /**
     * @MongoDB\Field(type="Datetime")
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
            'startTime' => $this->getStartTime()->format('c'),
            'endDate' => $this->getEndTime()->format('c'),
        ];
    }
}