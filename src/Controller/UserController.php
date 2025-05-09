<?php

namespace App\Controller;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/music-task')]
class UserController extends AbstractController
{

    private $userService;
    private $jsonSerialize;

    public function __construct(UserService $userService,
                         SerializerInterface $jsonSerialize
    )
    {
        $this->userService = $userService;
        $this->jsonSerialize = $jsonSerialize;
    }
    #[Route('/users',name: 'app_users', methods: ['GET'])]
    public function index():JsonResponse
    {
        try {
          $users=  $this->userService->findAll();
          $json = $this->jsonSerialize->serialize($users, 'json');
          return new JsonResponse($json, Response::HTTP_OK, [], true);
        }catch (\Exception $e){
            return new JsonResponse(
                ['error'=> 'hubo un error al recuperar usuarios'. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


}