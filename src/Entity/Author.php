<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $yearBorn = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $yearDied = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getYearBorn(): ?int
    {
        return $this->yearBorn;
    }

    public function getYearBornAsString(): ?string
    {
        return $this->yearBorn ? (string)$this->yearBorn : null;
    }

    public function setYearBorn(?int $yearBorn): static
    {
        $this->yearBorn = $yearBorn;

        return $this;
    }

    public function getYearDied(): ?int
    {
        return $this->yearDied;
    }

    public function getYearDiedAsString(): ?string
    {
        return $this->yearDied ? (string)$this->yearDied : null;
    }

    public function setYearDied(?int $yearDied): static
    {
        $this->yearDied = $yearDied;

        return $this;
    }
}
