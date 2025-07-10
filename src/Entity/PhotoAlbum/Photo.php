<?php

declare(strict_types=1);

namespace App\Entity\PhotoAlbum;

use App\Entity\User;
use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Filename cannot be blank')]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Filename must not be empty',
        maxMessage: 'Filename cannot be longer than {{ limit }} characters'
    )]
    #[Assert\Regex(
        pattern: '/^[\w\-. ]+\.(jpg|jpeg|png)$/i',
        message: 'Filename must be a valid image file (jpg, jpeg, png)'
    )]
    private ?string $filename = null;

    #[ORM\Column(type: Types::BLOB)]
    private $content;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Title cannot be blank', groups: ['form'])]
    #[Assert\Length(
        min: 1,
        max: 20,
        minMessage: 'Title must not be empty',
        maxMessage: 'Title cannot be longer than {{ limit }} characters',
        groups: ['form']
    )]
    #[Assert\Regex(
        pattern: '/^[\w\-\s.,!?]+$/u',
        message: 'Title can only contain letters, numbers, spaces, and basic punctuation',
        groups: ['form']
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Description cannot be blank', groups: ['form'])]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Description must not be empty',
        maxMessage: 'Description cannot be longer than {{ limit }} characters',
        groups: ['form']
    )]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Uploader must be specified')]
    #[Assert\Valid]
    private ?User $uploader = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUploader(): ?User
    {
        return $this->uploader;
    }

    public function setUploader(?User $uploader): static
    {
        $this->uploader = $uploader;

        return $this;
    }
}
