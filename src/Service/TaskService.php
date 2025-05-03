<?php

namespace App\Service;

use App\Dto\RequestDto\TaskRequestDto;
use App\Dto\ResponseDto\TaskResponseDto;
use App\Entity\Task;
use App\Entity\User;
use App\Enums\TaskCategory;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class TaskService
{

    private $taskRepository;
    private $security;
    private $entityManager;

    public function __construct(
        TaskRepository $taskRepository,
    EntityManagerInterface $entityManager,
        Security $security
    ){
        $this->taskRepository = $taskRepository;
        $this->entityManager  = $entityManager;
        $this->security       = $security;
    }

    public function taskFindUser() : array
    {

        $owner = $this->security->getUser();
        if (!$owner) {
            throw new \Exception("No authenticated user found.");
        }
        $tasks = $this->taskRepository->findBy(['owner' => $owner]);
       $taskDto = [];
       foreach ($tasks as $task) {
           $taskDto[] = $this->mapToTaskResponseDto($task);
       }
       return $taskDto;
    }


    public function mapToTaskResponseDto(Task $task) : TaskResponseDto
    {
       $taskDto = new TaskResponseDto();
       $taskDto->setId($task->getId());
       $taskDto->setTitle($task->getTitle());
       $taskDto->setDescription($task->getDescription());
       $taskDto->setTimeEstimate(new \DateTime($task->getEstimatedTime()));
       $taskDto->setCreatedAt(($task->getDate()));

       return $taskDto;
    }

    //crear una tarea

    public function createTask(TaskRequestDto $requestDto) : TaskResponseDto
    {
        $task = new Task();
        $owner = $this->security->getUser();

        $existingTask = $this->entityManager->getRepository(Task::class)->findOneBy([
            'title' => trim($requestDto->getTitle())
        ]);

        if ($existingTask) {
            throw new \Exception("Ya existe una tarea con ese título",400);
        }

        $category  = TaskCategory::tryFrom($requestDto->getCategory());
        if(!$category){
            throw new \Exception("categoria no valida",400);
        }
        $task->setTitle($requestDto->getTitle());
        $task->setDescription($requestDto->getDescription());
        $task->setCompleted(false);

        $task->setCategory($category->value);

        $task->setCompleted($requestDto->getCompleted());
        $task->setDate($requestDto->getDate());
        $task->setOwner($owner);

        $this->entityManager->persist($task);
        $this->entityManager->flush();
        return $this->mapToTaskResponseDto($task);
    }

    public function finById(int $id) : TaskResponseDto
    {
        $task = $this->taskRepository->find($id);
        if(!$task){
            throw new \Exception("Tarea no encontrada",400);
        }
        return $this->mapToTaskResponseDto($task);
    }
}