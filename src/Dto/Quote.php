<?php

declare(strict_types=1);

namespace App\Dto;

class Quote
{
    public function __construct(
        public string $quoteText,
        public string $authorName,
    ) {}
}
