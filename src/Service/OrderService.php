<?php

namespace App\Service;

use App\Document\Order;
use App\Document\User;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderService
{
    public function getAllDataByOrder(string $urlRestaurant, Order $order, HttpClientInterface $httpClient): JsonResponse
    {
        $response = new JsonResponse();
        $requestRestaurant = $httpClient->request(
            'GET',
            $urlRestaurant . $order->getRestaurant() . '/view'
        );
        $restaurant = json_decode($requestRestaurant->getContent());
        $menus = json_decode($requestMenus->getContent());
        $items = null;


        return $response;
    }

    public function orderSetters(array $request, DocumentManager $documentManager): Order
    {
        $order = new Order();
        $date = new DateTime();
        $itemsArray = $menusArray = [];

        if (isset($request["restaurant"]) && $request["restaurant"] !== "") {
            $order->setRestaurant($request["restaurant"]);
        }

        if (isset($request["client"]) && $request["client"] !== "") {
            $client = $documentManager->getRepository(User::class)->findOneBy(['_id' => $request["client"]]);
            $order->setClient($client);
        }

        if (isset($request["deliverer"]) && $request["deliverer"] !== "") {
            $deliver = $documentManager->getRepository(User::class)->findOneBy(['_id' => $request["deliverer"]]);
            $order->setDeliverer($deliver);
        }

        if (isset($request["price"]) && $request["price"] !== "") {
            $order->setPrice($request["price"]);
        }

        if (isset($request["deliveryPrice"]) && $request["deliveryPrice"] !== "") {
            $order->setDeliveryPrice($request["deliveryPrice"]);
        }

        $order->setStatus(Order::StatusArray[0]);

        if (isset($request["items"]) && $request["items"] !== []) {
            foreach ($request["items"] as $item) {
                $itemsArray[$item] = true;
            }
        }

        if (isset($request["menus"]) && $request["menus"] !== []) {
            foreach ($request["menus"] as $menu) {
                $menusArray[$menu] = true;
            }
        }

        $order->setItems(json_decode(json_encode($itemsArray)));
        $order->setMenus(json_decode(json_encode($menusArray)));
        $order->setStartTime($date);
        $order->setEndTime($date->modify('+1 hour'));
        $order->setDeliveryTime($date->modify('+0.5 hour'));

        return $order;
    }
}