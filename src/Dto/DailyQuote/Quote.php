<?php

declare(strict_types=1);

namespace App\Dto\DailyQuote;

readonly class Quote
{
    public function __construct(
        public int $quoteId,
        public string $quoteText,
        public int $quoteLikes,
        public string $authorName,
    ) {}
}
