<?php

declare(strict_types=1);

namespace App\Dto\TextBeautify;

class BeautificationInput
{
    public function __construct(
        private readonly string $text,
    ) {}

    public function getText(): string
    {
        return $this->text;
    }
}
