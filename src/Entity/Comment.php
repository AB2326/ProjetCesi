<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    /**
     * @var DateTimeInterface|DateTime|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface|DateTime|null $createdAt = null;

    /**
     * @return DateTime|DateTimeInterface|null
     */
    public function getCreatedAt(): DateTimeInterface|DateTime|null
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(DateTimeInterface|DateTime|null $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

}
