<?php

declare(strict_types=1);

namespace App\Dto\PhotoAlbum;

readonly class BulkPhotosDetails
{
    public function __construct(
        public string $title,
        public string $description,
    ) {
        //
    }
}
