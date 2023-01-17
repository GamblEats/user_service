<?php

namespace App\Repository;

use App\Document\Order;
use DateTime;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class OrderRepository extends DocumentRepository
{
    public function ordersByDateAndRestaurant(string $idRestaurant, DateTime $date): array
    {
        $qb = $this->dm->createQueryBuilder(Order::class)
            ->find()
            ->field('restaurant')->equals($idRestaurant)
            ->field('startTime')->gte($date)
            ->field('startTime')->lte(new DateTime())
            ->field('status')->notEqual("CANCELED")
            ->getQuery()
            ->execute()->toArray();

        return $qb;
    }
}