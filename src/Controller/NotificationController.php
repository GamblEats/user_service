<?php

namespace App\Controller;

use App\Document\Notification;
use App\Document\User;
use App\Service\NotificationService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private DocumentManager $dm;
    private NotificationService $notificationService;

    public function __construct(DocumentManager $documentManager, NotificationService $notificationService)
    {
        $this->dm = $documentManager;
        $this->notificationService = $notificationService;
    }

    /**
     * @Route("/users/{idUser}/notifications", name="notification_view", methods={"GET"})
     * @param Request $request
     * @param string $idUser
     * @return JsonResponse
     */
    public function getNotificationByUser(Request $request, string $idUser): JsonResponse
    {
        $response = new JsonResponse();
        $notificationsArray = [];
        $notifications = $this->dm->getRepository(Notification::class)->findBy([
            'user' => $this->dm->getRepository(User::class)->findOneBy(['_id' => $idUser])
        ]);
        foreach ($notifications as $notification) {
            $notificationsArray[] = $notification->toArray();
        }
        $response->setData($notificationsArray);
        $response->setStatusCode(200);


        return $response;
    }

    /**
     * @Route("/users/{userId}/notifications", name="notification_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addNotification(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);

        $notification = $this->notificationService->notificationSetters($requestData, $this->dm);

        try {
            $this->dm->persist($notification);
            $this->dm->flush();
            $response->setData('A notification was be created');
            $response->setStatusCode(200);
        } catch (\Exception $exception) {
            $response->setData('A notification cannot be created');
            $response->setStatusCode(404);
        }

        return $response;
    }
    /**
     * @Route("/users/{userId}/notifications/{notifyId}", name="notif_edit", methods={"PATCH"})
     * @param Request $request
     * @param string $notifyId
     * @return JsonResponse
     */
    public function editNotif(Request $request, string $notifyId): JsonResponse
    {
        $response = new JsonResponse();
        $notif = $this->dm->getRepository(Notification::class)->findOneBy(['_id' => $notifyId]);

        try {
            $notif->setIsRead(true);
            $this->dm->persist($notif);
            $this->dm->flush();
            $response->setData('The notify ' . $notifyId . ' was read.');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }


    /**
     * @Route("/users/{userId}/notifications/{notifyId}", name="notif_delete", methods={"DELETE"})
     * @param Request $request
     * @param string $notifyId
     * @return JsonResponse
     */
    public function deleteNotif(Request $request, string $notifyId): JsonResponse
    {
        $response = new JsonResponse();
        $notif = $this->dm->getRepository(Notification::class)->findOneBy(['_id' => $notifyId]);

        try {
            $this->dm->remove($notif);
            $this->dm->flush();
            $response->setData('The notify ' . $notifyId . ' was deleted.');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }
}