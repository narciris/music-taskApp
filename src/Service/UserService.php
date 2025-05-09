<?php

namespace App\Service;


use App\Dto\ResponseDto\UserResponseDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserService
{

    private UserRepository $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $entityManager
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;

    }
     /***
      * mostrar todos los usuarios
     */

public function findAll(): array
{
    $users = [];
  $response =  $this->userRepository->findAll();

    foreach ($response as $user) {
        $users[] = $this->mapToUserResponseDto($user);
    }
    return $users;
}

 public function mapToUserResponseDto(User $user): UserResponseDto
 {
     $dto = new UserResponseDto();
     $dto->setId($user->getId());
     $dto->setName($user->getName());
     $dto->setEmail($user->getEmail());
     $dto->setLastname($user->getLastname());
     return  $dto;
 }
}