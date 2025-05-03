<?php

namespace App\Service;


use App\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }



}