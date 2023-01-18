<?php

namespace App\Service;

use App\Document\Notification;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;

class NotificationService
{
    public function notificationSetters(array $request, DocumentManager $documentManager): Notification
    {
        $notification = new Notification();

        if (isset($request["title"]) && $request["title"] !== "") {
            $notification->setTitle($request["title"]);
        }

        if (isset($request["message"]) && $request["message"] !== "") {
            $notification->setMessage($request["message"]);
        }

        if (isset($request["user"]) && $request["user"] !== "") {
            $user = $documentManager->getRepository(User::class)->findOneBy(['_id' => $request["user"]]);
            $notification->setUser($user);
        }

        $notification->setIsRead(false);


        return $notification;
    }
}