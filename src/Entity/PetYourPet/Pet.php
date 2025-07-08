<?php

namespace App\Entity\PetYourPet;

use App\Repository\PetRepository;
use App\Service\PetYourPet\PetMood;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
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
