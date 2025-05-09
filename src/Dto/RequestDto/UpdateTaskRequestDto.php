<?php

namespace App\Dto\RequestDto;

use App\Entity\User;

class UpdateTaskRequestDto
{

    private ?string $title = null;
    private ?string $description = null;
    private ?\DateTime $estimatedTime = null;
    private ?\DateTime $date = null;
    private ?string $category = null;

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



}