<?php

namespace App\Dto\ResponseDto;

class TaskResponseDto implements \JsonSerializable
{
   private $id;
   private string $title;
   private string $description;
   private \DateTime $timeEstimate;
   private \DateTime $createdAt;

    public function getTimeEstimate(): \DateTime
    {
        return $this->timeEstimate;
    }

    public function setTimeEstimate(\DateTime $timeEstimate): void
    {
        $this->timeEstimate = $timeEstimate;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'timeEstimate' => $this->timeEstimate,
            'createdAt' => $this->createdAt,

        ];
    }
}