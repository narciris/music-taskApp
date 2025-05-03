<?php

namespace App\Dto\RequestDto;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
class TaskRequestDto
{
    #[Assert\NotBlank(message: "El título no puede estar vacío")]
    private ?string $title = null;
    #[Assert\NotBlank(message: "La descripcion no puede estar vacío")]
    private ?string $description = null;
    #[Assert\NotNull(message: "no puede estar vacio el tiempo estimado")]
    private ?\DateTime $estimatedTime = null;
    #[Assert\NotNull(message: "no puede estar vacioa la fecha")]
    private ?\DateTime $date = null;
    #[Assert\NotBlank(message: "La categoria no puede estar vacío")]
    private ?string $category = null;
    #[Assert\IsNull(message: "no puede esta vacio")]
    private ?User $owner;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getEstimatedTime(): ?\DateTime
    {
        return $this->estimatedTime;
    }

    public function setEstimatedTime(?\DateTime $estimatedTime): void
    {
        $this->estimatedTime = $estimatedTime;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $completed): void
    {
        $this->completed = $completed;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
    }

}