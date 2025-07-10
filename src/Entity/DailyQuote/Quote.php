<?php

namespace App\Entity\DailyQuote;

use App\Repository\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    #[Assert\NotBlank(message: 'Quote text cannot be blank')]
    #[Assert\Length(
        min: 1,
        max: 1000,
        minMessage: 'Quote must not be empty',
        maxMessage: 'Quote cannot be longer than {{ limit }} characters'
    )]
    private ?string $text = null;

    #[ORM\ManyToOne(targetEntity: Author::class, fetch: 'EAGER')]
    #[Assert\NotNull(message: 'Author must be specified')]
    #[Assert\Valid]
    private ?Author $author = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Category cannot be blank')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Category must be at least {{ limit }} characters long',
        maxMessage: 'Category cannot be longer than {{ limit }} characters'
    )]
    private ?string $category = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Likes count must be specified')]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'Likes count cannot be negative'
    )]
    private ?int $likes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }
}
