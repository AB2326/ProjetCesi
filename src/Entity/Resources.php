<?php

namespace App\Entity;

use App\Repository\ResourcesRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
#[ORM\Entity(repositoryClass: ResourcesRepository::class)]
class Resources
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $content = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;


    /**
     * @var bool|null
     */
    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $status = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    /**
     * @var DateTimeInterface|DateTime|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface|DateTime|null $createdAt = null;

    /**
     * @var DateTimeInterface|DateTime|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface|DateTime|null $updatedAt = null;

    /**
     * @var DateTimeInterface|DateTime|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface|DateTime|null $deletedAt = null;

    /**
     * @var bool|null
     */
    #[ORM\Column]
    private ?bool $isDeleted = null;

    /**
     * @var bool|null
     */
    #[ORM\Column]
    private ?bool $isCompleted = null;

    /**
     * @var bool|null
     */
    #[ORM\Column]
    private ?bool $isRestricted = null;

//    /**
//     * @var User|null
//     */
//    #[ORM\ManyToOne(targetEntity: User::class)]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?User $createdBy = null;

    /**
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param User|null $createdBy
     */
    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     *
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /* Getters Setters */
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return $this
     */
    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool|null $status
     * @return $this
     */
    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTimeInterface $deletedAt
     * @return $this
     */
    public function setDeletedAt(DateTimeInterface $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     * @return $this
     */
    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     * @return $this
     */
    public function setIsCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIsRestricted(): ?bool
    {
        return $this->isRestricted;
    }

    /**
     * @param bool $isRestricted
     * @return $this
     */
    public function setIsRestricted(bool $isRestricted): static
    {
        $this->isRestricted = $isRestricted;

        return $this;
    }
}
