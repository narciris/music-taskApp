<?php

namespace App\Controller;

use App\Dto\RequestDto\TaskRequestDto;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/music-task')]
class TaskController extends AbstractController
{

    private $serviceTask;
    private $serializer;
    private $validator;

    public function __construct(
        TaskService $serviceTask,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->serviceTask = $serviceTask;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }
    #[Route('/find',name: 'app_index',methods: ['GET'])]
    public function findAllTask()
    {
        try {
            $user = $this->getUser();
            $tasks = $this->serviceTask->taskFindUser($user);

            return new JsonResponse(
                $this->serializer->serialize($tasks, 'json'),
                Response::HTTP_OK,
                [],
                true
            );
        }catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() :
                    Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
   #[Route('/create',name: 'app_create',methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $user =  $this->getUser();
           $requestDto = $this->serializer->deserialize($request->getContent(),
               TaskRequestDto::class, 'json');

            $errors = $this->validator->validate($requestDto);

            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()] = $error->getMessage();
                }

                return new JsonResponse(
                    ['errors' => $errorMessages],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $taskResult=  $this->serviceTask->createTask($requestDto);
            return new JsonResponse(
                $taskResult,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => 'An error occurred while creating the task: ' . $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/find/{id}',name: 'app_find_id',methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        try {

            $taskFind = $this->serviceTask->taskFindUser($id);
            return new JsonResponse(
                $taskFind,
                Response::HTTP_OK
            );
        }  catch (\Exception $e) {
            return new JsonResponse(
                ['error' => 'An error occurred while finding the task: ' . $e->getMessage()],
            );
        }
    }
}