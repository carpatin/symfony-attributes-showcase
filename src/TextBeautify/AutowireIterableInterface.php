<?php

declare(strict_types=1);

namespace App\TextBeautify;

interface AutowireIterableInterface
{
    public static function getIteratorIndex(): string;

    public static function getIteratorPriority(): int;
}
