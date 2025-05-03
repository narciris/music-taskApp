<?php

namespace App\Controller;

use App\Dto\RequestDto\RequestUserDto;
use App\Service\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/music-task')]
class AuthController
{
    private $serialize;
    private $validator;
    private $authService;

    public function __construct(
        SerializerInterface $serializer,
        AuthService $authService,
        ValidatorInterface $validator
    ){
        $this->serialize = $serializer;
        $this->authService = $authService;
        $this->validator = $validator;
    }
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        try {
            $userDto = $this->serialize->deserialize(
                $request->getContent(),
                RequestUserDto::class,
                'json'
            );

            $responseDto = $this->authService->registerUser($userDto);
            return new JsonResponse(
                $this->serialize->serialize($responseDto, 'json'),
                Response::HTTP_CREATED,
                [],
                true
            );
        }catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
#[Route('/login',name: 'app_login',methods: ['POST'])]
    public function login(Request $request)
{
}
}