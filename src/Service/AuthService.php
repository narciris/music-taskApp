<?php

namespace App\Service;

use App\Dto\RequestDto\LoginRequestDto;
use App\Dto\RequestDto\RequestUserDto;
use App\Dto\ResponseDto\TokenResponseDto;
use App\Dto\ResponseDto\UserResponseDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthService
{

    private $repositoryUser;
    private $entityManager;
    private $jwtManage;

    public function __construct(
        UserRepository $repositoryUser,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface  $jwtManage
    )
    {
        $this->repositoryUser = $repositoryUser;
        $this->entityManager = $entityManager;
        $this->jwtManage = $jwtManage;
    }
    public function registerUser(RequestUserDto $requestDto)
    {
        $existsByEmail = $this->repositoryUser->findOneBy(
            ['email' => $requestDto->getEmail()]);
        if($existsByEmail){
            throw new \Exception('usuario ya esta registrado ',406);
        }

        $user = new User();
        $user->setEmail($requestDto->getEmail());
        $user->setLastname($requestDto->getLastname());
        $user->setName($requestDto->getName());

        $passwordHashed = password_hash($requestDto->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($passwordHashed);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $this->mapToUserResponseDto($user);
    }

    public function mapToUserResponseDto(User $user) : UserResponseDto
    {
        $userResponseDto = new UserResponseDto();
        $userResponseDto->setName($user->getName());
        $userResponseDto->setEmail($user->getEmail());
        $userResponseDto->setLastname($user->getLastname());
        $userResponseDto->setId($user->getId());

        return $userResponseDto;
    }

//    public function login(LoginRequestDto $loginRequest): TokenResponseDto
//    {
//      $user = $this->repositoryUser->findOneBy(['email'=>$loginRequest->getEmail()]);
//      if(!$user){
//          throw new \Exception("Usuario o contraseña incorrector");
//
//      }
//
//      if(!password_verify($loginRequest->getPassword(), $user->getPassword())){
//          throw new \Exception("Usuario o contraseña incorrectos");
//      }
//
//      $token = $this->jwtManage->create($user);
//      $tokenResponse = new TokenResponseDto();
//      $tokenResponse->setId($user->getId());
//      $tokenResponse->setName($user->getName());
//      $tokenResponse->setEmail($user->getEmail());
//      $tokenResponse->setAccessToken($token);
//
//      return $tokenResponse;
//
//
//    }


}