<?php

namespace App\Entity;

use App\Repository\StatsUsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatsUsersRepository::class)]
class StatsUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $keyWord = null;

    #[ORM\Column]
    private ?int $connection = null;

    #[ORM\Column]
    private ?int $connectedTime = null;

    #[ORM\Column(length: 255)]
    private ?string $searchByRegion = null;

    #[ORM\Column(length: 255)]
    private ?string $searchByCountry = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getKeyWord(): ?string
    {
        return $this->keyWord;
    }

    public function setKeyWord(string $keyWord): static
    {
        $this->keyWord = $keyWord;

        return $this;
    }

    public function getConnection(): ?int
    {
        return $this->connection;
    }

    public function setConnection(int $connection): static
    {
        $this->connection = $connection;

        return $this;
    }

    public function getConnectedTime(): ?int
    {
        return $this->connectedTime;
    }

    public function setConnectedTime(int $connectedTime): static
    {
        $this->connectedTime = $connectedTime;

        return $this;
    }

    public function getSearchByRegion(): ?string
    {
        return $this->searchByRegion;
    }

    public function setSearchByRegion(string $searchByRegion): static
    {
        $this->searchByRegion = $searchByRegion;

        return $this;
    }

    public function getSearchByCountry(): ?string
    {
        return $this->searchByCountry;
    }

    public function setSearchByCountry(string $searchByCountry): static
    {
        $this->searchByCountry = $searchByCountry;

        return $this;
    }
}
