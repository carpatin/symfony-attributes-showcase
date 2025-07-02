<?php

declare(strict_types=1);

namespace App\TextBeautify\CharPadding;

use App\TextBeautify\AutowireIterableInterface;

class HeartsPaddingBeautifier implements PaddingBeautifierInterface, AutowireIterableInterface
{
    public function beautify(string $text): string
    {
        return '❤'.$text.'❤';
    }

    public static function getIteratorIndex(): string
    {
        return 'hearts_padding';
    }

    public static function getIteratorPriority(): int
    {
        return 50;
    }
}
