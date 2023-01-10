<?php

namespace App\Service;

use App\Document\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderService
{
    public function getAllDataByOrder(string $urlRestaurant, Order $order, HttpClientInterface $httpClient): JsonResponse
    {
        $response = new JsonResponse();
        $httpClient =
        $requestRestaurant = $httpClient->request(
            'GET',
            $urlRestaurant . $order->getRestaurant() . '/view'
        );
//        $requestMenus = $httpClient->request(
//            'GET',
//            $urlRestaurant . getMenus() . '/view'
//        );
        $restaurant = json_decode($requestRestaurant->getContent());
//        $menus = json_decode($requestMenus->getContent());
//        $items = null;


        return $response;
    }
}