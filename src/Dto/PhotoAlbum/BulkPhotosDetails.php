<?php

declare(strict_types=1);

namespace App\Dto\PhotoAlbum;

use Symfony\Component\Validator\Constraints as Assert;

readonly class BulkPhotosDetails
{
    public function __construct(
        #[Assert\NotBlank(message: 'Title cannot be blank')]
        #[Assert\Length(
            min: 1,
            max: 20,
            minMessage: 'Title must not be empty',
            maxMessage: 'Title cannot be longer than {{ limit }} characters'
        )]
        #[Assert\Regex(
            pattern: '/^[\w\-\s.,!?]+$/u',
            message: 'Title can only contain letters, numbers, spaces, and basic punctuation'
        )]
        public string $title,
        #[Assert\NotBlank(message: 'Description cannot be blank')]
        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Description must not be empty',
            maxMessage: 'Description cannot be longer than {{ limit }} characters'
        )]
        public string $description,
    ) {
        //
    }
}
