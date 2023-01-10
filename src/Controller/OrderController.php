<?php

namespace App\Controller;

use App\Document\Order;
use App\Document\User;
use App\Service\OrderService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderController extends AbstractController
{
    private DocumentManager $dm;
    private OrderService $orderService;
    private string $urlRestaurant;

    public function __construct(DocumentManager $documentManager, OrderService $orderService, string $urlRestaurant)
    {
        $this->dm = $documentManager;
        $this->orderService = $orderService;
        $this->urlRestaurant = $urlRestaurant;
    }

    /**
     * @Route("order/{idUser}/list", name="order_list")
     * @param string $idUser
     * @param HttpClientInterface $httpClient
     * @return JsonResponse
     */
    public function ordersByUser(string $idUser, HttpClientInterface $httpClient): JsonResponse
    {
        $response = new JsonResponse();
        $ordersArray = [];
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $idUser]);
        $orders = $this->dm->getRepository(Order::class)->findBy(['user' => $user]);
        foreach ($orders as $order) {
            $orderArray = $order->toArray();
            $ordersArray[] = $orderArray;
        }

        $response->setData($ordersArray);

        return $response;
    }

    /**
     * @Route("order/{idUser}/list/{idOrder}/view", name="order_view")
     * @param string $idUser
     * @param string $idOrder
     * @return JsonResponse
     */
    public function orderByUser(string $idUser, string $idOrder): JsonResponse
    {
        $response = new JsonResponse();
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $idUser]);
        $order = $this->dm->getRepository(Order::class)->findBy(['user' => $user, '_id' => $idOrder]);

        $response->setData($order->toArray());

        return $response;
    }
}