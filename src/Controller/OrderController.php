<?php

namespace App\Controller;

use App\Document\Order;
use App\Document\User;
use App\Service\OrderService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/orders/{idUser}", name="orders_list")
     * @param Request $request
     * @param string $idUser
     * @return JsonResponse
     */
    public function ordersByUser(Request $request, string $idUser): JsonResponse
    {
        $response = new JsonResponse();
        $ordersArray = [];
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $idUser]);
        $orders = $this->dm->getRepository(Order::class)->findBy(['client' => $user]);
        foreach ($orders as $order) {
            $orderArray = $order->toArray();
            $ordersArray[] = $orderArray;
        }

        $response->setData($ordersArray);

        return $response;
    }

    /**
     * @Route("/order", name="order_view")
     * @param Request $request
     * @return JsonResponse
     */
    public function orderByUser(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $requestData["idUser"]]);
        $order = $this->dm->getRepository(Order::class)->findOneBy(['client' => $user, '_id' => $requestData["idOrder"]]);
        $response->setData($order->toArray());

        return $response;
    }
}