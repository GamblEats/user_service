<?php

namespace App\Controller;

use App\Document\User;
use App\Service\UserService;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class UserController extends AbstractController
{
    private DocumentManager $dm;
    private UserService $userService;
    private UserPasswordHasherInterface $passwordHasher;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private LoggerInterface $logger;

    public function __construct(DocumentManager $documentManager, UserService $userService, UserPasswordHasherInterface $passwordHasher, CsrfTokenManagerInterface $csrfTokenManager, LoggerInterface $logger)
    {
        $this->dm = $documentManager;
        $this->userService = $userService;
        $this->passwordHasher = $passwordHasher;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->logger = $logger;
    }

    /**
     * @Route("/user/sign-up", name="sign_up")
     * @param Request $request
     * @return Response
     */
    public function signUp(Request $request): Response
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);

        $user = $this->userService->userSetters($requestData);

        if ($this->dm->getRepository(User::class)->findOneBy(['email' => $requestData["email"]])) {
            $response->setData('A user is already create with this address');
            $response->setStatusCode(401);
            $this->logger->info('Already exists to : ' . $requestData["email"]);
            return $response;
        }

        try {
            $this->dm->persist($user);
            $this->dm->flush();
            $response->setData('A user was be created');
            $response->setStatusCode(200);
            $date = new DateTime();
            $this->logger->info('User created : ' . $user->getEmail() . ' at ' . $date->format('H/M/Y'));
        } catch (\Exception $exception) {
            $response->setData('A user cannot be created');
            $response->setStatusCode(404);
            $this->logger->critical('Error dectected : ' . $exception->getMessage());
        }

        return $response;
    }

    /**
     * @Route("/user/sign-in", name="sign_in")
     */
    public function signIn(Request $request): Response
    {
        $response = new JsonResponse();

        $requestData = json_decode($request->getContent(), true);

        $user = $this->dm->getRepository(User::class)->findOneBy(['email' => $requestData["email"]]);

        if (isset($requestData["password"]) && $requestData !== "") {
            if ($this->userService->passwordIsValid($user, $requestData["password"])) {
                $token = $this->csrfTokenManager->getToken($user->getEmail() . $user->getType() . $user->getPassword())->getValue(); // Make more token body request + password
                $responseArray = [
                    'message' => 'You can Access',
                    'token' => $token
                ];
                $response->setData($responseArray);
                $response->setStatusCode(200);
            } else {
                $response->setData('Wrong Password');
                $response->setStatusCode(502);
            }
        } else {
            $response->setData('Any Password');
            $response->setStatusCode(502);
        }
        return $response;
    }

    /**
     * @Route("user", name="user_view")
     * @param Request $request
     * @return JsonResponse
     */
    public function findUserById(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $user = $this->dm->getRepository(User::class)->findOneBy(['_id' => $requestData["idUser"]]);

        $response->setStatusCode(200);
        $response->setData($user->toArray());

        return $response;
    }

//$result = $this->isCsrfTokenValid($user->getEmail(). 'e', $token); For check if valid in back
}