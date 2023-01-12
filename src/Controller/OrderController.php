<?php

namespace App\Controller;

use App\Document\Order;
use App\Document\User;
use App\Service\CommunicationService;
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
    private CommunicationService $communicationService;
    private string $urlRestaurant;
    private HttpClientInterface $httpClient;

    public function __construct(DocumentManager $documentManager, OrderService $orderService, string $urlRestaurant, CommunicationService $communicationService, HttpClientInterface $httpClient)
    {
        $this->dm = $documentManager;
        $this->orderService = $orderService;
        $this->urlRestaurant = $urlRestaurant;
        $this->communicationService = $communicationService;
        $this->httpClient = $httpClient;
    }

    /**
     * @Route("/orders/{idUser}", name="orders_list", methods={"GET"})
     * @param string $idUser
     * @return JsonResponse
     */
    public function ordersByUser(string $idUser): JsonResponse
    {
        $response = new JsonResponse();
        $ordersArray = [];
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $idUser]);
        $orders = $this->dm->getRepository(Order::class)->findBy(['client' => $user]);
        foreach ($orders as $order) {
            $orderArray = $order->toArray();
            $orderArray['restaurant'] = $this->communicationService->getRestaurantById($this->httpClient, $order->getRestaurant());
            $orderArray['items'] = [];
            foreach ($order->getItems() as $key => $item) {
                $itemObject = $this->communicationService->getItemById($this->httpClient, $key);
                if ($itemObject) {
                    $orderArray['items'][] = $itemObject;
                }
            }
            foreach ($order->getMenus() as $key => $menu) {
                $menuObject = $this->communicationService->getMenuById($this->httpClient, $key);
                if ($menuObject) {
                    $orderArray['menus'][] = $menuObject;
                }
            }
            $ordersArray[] = $orderArray;
        }

        $response->setData($ordersArray);

        return $response;
    }

    /**
     * @Route("/users/{idUser}/orders/{idOrder}", name="order_view", methods={"GET"})
     * @param Request $request
     * @param string $idUser
     * @param string $idOrder
     * @return JsonResponse
     */
    public function orderByUser(Request $request, string $idUser, string $idOrder): JsonResponse
    {
        $response = new JsonResponse();
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $idUser]);
        $order = $this->dm->getRepository(Order::class)->findOneBy(['client' => $user, '_id' => $idOrder]);
        $response->setData($order->toArray());

        return $response;
    }

    /**
     * @Route("/orders", name="order_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addOrder(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);

        $order = $this->orderService->orderSetters($requestData, $this->dm);

        try {
            $this->dm->persist($order);
            $this->dm->flush();
            $response->setData('A order was be created');
            $response->setStatusCode(200);
        } catch (\Exception $exception) {
            $response->setData('A order cannot be created');
            $response->setStatusCode(404);
        }

        return $response;
    }

    /**
     * @Route("/orders", name="order_edit", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function editOrder(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $order = $this->dm->getRepository(Order::class)->findOneBy(['_id' => $requestData['idOrder']]);

        $order = $this->orderService->orderEdite($requestData, $this->dm, $order);

        try {
            $this->dm->persist($order);
            $this->dm->flush();
            $response->setData('A order was be edited');
            $response->setStatusCode(200);
        } catch (\Exception $exception) {
            $response->setData('A order cannot be edited');
            $response->setStatusCode(404);
        }

        return $response;
    }

    /**
     * @Route("/orders/{idOrder}", name="order_delete", methods={"DELETE"})
     * @param string $idOrder
     * @return JsonResponse
     */
    public function deleteOrder(string $idOrder): JsonResponse
    {
        $response = new JsonResponse();
        $order = $this->dm->getRepository(Order::class)->findOneBy(['_id' => $idOrder]);

        try {
            $this->dm->remove($order);
            $this->dm->flush();
            $response->setData('A order was be deleted');
            $response->setStatusCode(200);
        } catch (\Exception $exception) {
            $response->setData('A order cannot be deleted');
            $response->setStatusCode(404);
        }

        return $response;
    }
}