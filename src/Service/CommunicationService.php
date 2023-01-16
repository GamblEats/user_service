<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommunicationService
{
    private string $urlRestaurant;

    public function __construct(string $urlRestaurant) {
        $this->urlRestaurant = $urlRestaurant;
    }

    public function getRestaurantById(HttpClientInterface $httpClient, string $idRestaurant)
    {
        $response = $httpClient->request(
            'GET',
            $this->urlRestaurant . 'restaurants/' .$idRestaurant
        );


        return json_decode($response->getContent(), true);
    }

    public function getItemById(HttpClientInterface $httpClient, string $idItem)
    {
        $response = $httpClient->request(
            'GET',
            $this->urlRestaurant . 'items/' . $idItem
        );


        return json_decode($response->getContent(), true);
    }

    public function getMenuById(HttpClientInterface $httpClient, string $idMenu)
    {
        $response = $httpClient->request(
            'GET',
            $this->urlRestaurant . 'menus/' . $idMenu
        );


        return json_decode($response->getContent(), true);
    }
}