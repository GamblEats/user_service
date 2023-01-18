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
            ->field('restaurant.id')->equals($idRestaurant)
            ->field('startTime')->gte($date)
            ->field('startTime')->lte(new DateTime())
            ->field('status')->notEqual("CANCELED")
            ->getQuery()
            ->execute()->toArray();

        return $qb;
    }

    public function findAllByCity(string $city)
    {
        $qb = $this->dm->createQueryBuilder(Order::class)
            ->field('restaurant.city')->equals($city)
            ->field('status')->equals("READY_TO_PICKUP")
            ->getQuery()
            ->execute()->toArray();

        return $qb;
    }

    public function findAllByDeliverer(string $idDeliverer)
    {
        $qb = $this->dm->createQueryBuilder(Order::class)
            ->field('deliverer')->equals($idDeliverer);

        $qb->addOr($qb->expr()->field('status')->equals('ON_THE_WAY'));
        $qb->addOr($qb->expr()->field('status')->equals('AT_YOUR_DOOR'));

        return $qb->getQuery()->getSingleResult()->toArray();
    }
}