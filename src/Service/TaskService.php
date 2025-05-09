<?php

namespace App\Service;

use App\Dto\RequestDto\TaskRequestDto;
use App\Dto\RequestDto\UpdateTaskRequestDto;
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
       $taskDto->setCompleted($task->isCompleted());

       return $taskDto;
    }

    //crear una tarea

    public function createTask(TaskRequestDto $requestDto) : TaskResponseDto
    {
        $task = new Task();
        $owner = $this->security->getUser();

        $existingTask = $this->entityManager->
        getRepository(Task::class)->findOneBy([
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

    public function findById(int $id) : TaskResponseDto
    {
        $task = $this->taskRepository->find($id);
        if (!$task || $task->getOwner()!== $this->security->getUser()) {
            throw new \Exception("Tarea no encontrada o no autorizada", 403);
        }

        return $this->mapToTaskResponseDto($task);
    }


    public function updateTask(int $id, UpdateTaskRequestDto $requestDto) : TaskResponseDto
    {
        $task = $this->taskRepository->find($id);
        if(!$task){
            throw new \Exception(" la tarea no existe");
        }
        if($task->getOwner() !== $this->security->getUser() ){
            throw new \Exception("tarea no le pertenece", 403);
        }

        if($requestDto->getTitle() !== $task->getTitle() && !empty($requestDto->getTitle())){
            $task->setTitle($requestDto->getTitle());
        }
        if(!empty($requestDto->getDescription())){
            $task->setDescription($requestDto->getDescription());
        }

        if(!empty($requestDto->getDate())){
            $task->setDate($requestDto->getDate());
        }
        if(!empty($requestDto->getCategory())){
            $task->setCategory($requestDto->getCategory());
        }

        $this->entityManager->flush();

        return $this->mapToTaskResponseDto($task);

    }

    public function deleteTask(int $id) : TaskResponseDto
    {
        $task = $this->taskRepository->find($id);
        if(!$task || $task->getOwner()!== $this->security->getUser()) {
            throw new \Exception("Tarea no encontrada o no autorizada", 403);
        }
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        return $this->mapToTaskResponseDto($task);
    }

    public function changeStatus(int $id ): TaskResponseDto
    {
        $task = $this->taskRepository->find($id);
        if(!$task){
            throw new \Exception("tarea no disponible");
        }

        $task->setCompleted(true);
        $this->entityManager->flush();
        return $this->mapToTaskResponseDto($task);
    }
}