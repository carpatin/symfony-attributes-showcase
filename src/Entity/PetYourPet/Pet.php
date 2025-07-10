<?php

namespace App\Entity\PetYourPet;

use App\Repository\PetRepository;
use App\Service\PetYourPet\PetMood;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: 'This pet name is already taken.'
)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Pet name cannot be blank')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Pet name must be at least {{ limit }} characters long',
        maxMessage: 'Pet name cannot be longer than {{ limit }} characters'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\-\s]+$/',
        message: 'Pet name can only contain letters, numbers, spaces, and hyphens'
    )]
    private string $name;

    #[ORM\Column(options: ['default' => false])]
    private bool $isThirsty = false;

    #[ORM\Column(options: ['default' => false])]
    private bool $isHungry = false;

    #[ORM\Column(enumType: PetMood::class, options: ['default' => PetMood::RELAXED->value])]
    private PetMood $mood = PetMood::RELAXED;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isThirsty(): bool
    {
        return $this->isThirsty;
    }

    public function setIsThirsty(bool $isThirsty): static
    {
        $this->isThirsty = $isThirsty;

        return $this;
    }

    public function isHungry(): bool
    {
        return $this->isHungry;
    }

    public function setIsHungry(bool $isHungry): static
    {
        $this->isHungry = $isHungry;

        return $this;
    }

    public function getMood(): PetMood
    {
        return $this->mood;
    }

    public function setMood(PetMood $mood): static
    {
        $this->mood = $mood;

        return $this;
    }
}
