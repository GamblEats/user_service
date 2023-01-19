<?php

namespace App\Repository;

use App\Document\Order;
use DateTime;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Regex;

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
            ->field('restaurant.city')->equals(new Regex('^' . $city, 'i'))
            ->field('deliverer')->equals(null);
        $qb->addOr($qb->expr()->field('status')->equals("IN_PREPARATION"));
        $qb->addOr($qb->expr()->field('status')->equals("READY_TO_PICKUP"));

        return $qb->getQuery()->execute();
    }

    public function findAllByDeliverer(string $idDeliverer)
    {
        $qb = $this->dm->createQueryBuilder(Order::class)
            ->field('deliverer')->equals(new ObjectId($idDeliverer));

        $qb->addOr($qb->expr()->field('status')->equals('IN_PREPARATION'));
        $qb->addOr($qb->expr()->field('status')->equals('READY_TO_PICKUP'));
        $qb->addOr($qb->expr()->field('status')->equals('ON_THE_WAY'));
        $qb->addOr($qb->expr()->field('status')->equals('AT_YOUR_DOOR'));

        return $qb->getQuery()->getSingleResult();
    }
}