<?php

namespace App\Entity\DailyQuote;

use App\Repository\AuthorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank(message: 'Author name cannot be blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Author name must be at least {{ limit }} characters long',
        maxMessage: 'Author name cannot be longer than {{ limit }} characters'
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull(message: 'Year of birth must be provided')]
    #[Assert\Range(
        notInRangeMessage: 'Birth year must be between {{ min }} and {{ max }}',
        min: -3000,
        max: 2025
    )]
    private ?int $yearBorn = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull(message: 'Year of death must be provided')]
    #[Assert\Range(
        notInRangeMessage: 'Death year must be between {{ min }} and {{ max }}',
        min: -3000,
        max: 2025
    )]
    #[Assert\Expression(
        "this.getYearDied() > this.getYearBorn()",
        message: 'Death year must be after birth year'
    )]
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
