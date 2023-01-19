<?php

namespace App\Service;

use App\Document\Notification;
use App\Document\Order;
use App\Document\User;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderService
{
    public function orderSetters(array $request, DocumentManager $documentManager, CommunicationService $communicationService, HttpClientInterface $httpClient): Order
    {
        $order = new Order();
        $date = new DateTime();
        $itemsArray = $menusArray = [];

        if (isset($request["restaurant"]) && $request["restaurant"] !== "") {
            $restaurant = $communicationService->getRestaurantById($httpClient, $request["restaurant"]);
            $order->setRestaurant($restaurant);
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
                $newItem = $communicationService->getItemById($httpClient, $item);
                $itemsArray[] = $newItem;
            }
            $order->setItems(json_decode(json_encode($itemsArray)));
        }

        if (isset($request["menus"]) && $request["menus"] !== []) {
            foreach ($request["menus"] as $menu) {
                $newMenu = $communicationService->getMenuById($httpClient, $menu);
                $menusArray[] = $newMenu;
            }
            $order->setMenus(json_decode(json_encode($menusArray)));
        }

        $order->setStartTime($date);
        $order->setEndTime($date->modify('+1 hour'));
        $order->setDeliveryTime($date->modify('+0.5 hour'));

        return $order;
    }

    public function orderEdite(array $request, DocumentManager $documentManager, Order $order, HttpClientInterface $httpClient, CommunicationService $communicationService): Order
    {
        $itemsArray = $menusArray = [];

        if(isset($request["restaurant"])) {
            $restaurant = $communicationService->getRestaurantById($httpClient, $request["restaurant"]);
            $order->setRestaurant($restaurant);
        }

        if(isset($request["price"]) && $request["price"] !== $order->getPrice()) {
            $order->setPrice($request["price"]);
        }

        if(isset($request["deliveryPrice"]) && $request["deliveryPrice"] !== $order->getDeliveryPrice()) {
            $order->setDeliveryPrice($request["deliveryPrice"]);
        }

        if(isset($request["client"]) && $request["client"] !== $order->getClient()->getId()) {
            $client = $documentManager->getRepository(User::class)->findOneBy(['_id' => $request["client"]]);
            $order->setClient($client);
        }

        if(isset($request["status"]) && in_array($request["status"], Order::StatusArray)) {
            $order->setStatus($request["status"]);
            if ($request["status"] === "DELIVERED") {
                $client = $order->getClient();
                $notif = new Notification();
                $notif->setTitle('Commande Livrée');
                $notif->setMessage("Votre commande a été livrée, n'hésitez pas à la noter!");
                $notif->setUser($client);
                $notif->setIsRead(false);
                $documentManager->persist($notif);
                $documentManager->flush();
            }
        }

        if(isset($request["deliverer"]) && $request["deliverer"] !== $order->getDeliverer()->getId()) {
            $deliverer = $documentManager->getRepository(User::class)->findOneBy(['_id' => $request["deliverer"]]);
            $order->setDeliverer($deliverer);
        }

        if (isset($request["items"]) && $request["items"] !== []) {
            foreach ($request["items"] as $item) {
                $newItem = $communicationService->getItemById($httpClient, $item);
                $itemsArray[] = $newItem;
            }
            $order->setItems(json_decode(json_encode($itemsArray)));
        }

        if (isset($request["menus"]) && $request["menus"] !== []) {
            foreach ($request["menus"] as $menu) {
                $newMenu = $communicationService->getMenuById($httpClient, $menu);
                $menusArray[] = $newMenu;
            }
            $order->setMenus(json_decode(json_encode($menusArray)));
        }

        return $order;
    }
}