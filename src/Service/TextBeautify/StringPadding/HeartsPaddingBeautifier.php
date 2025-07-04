<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\StringPadding;

use App\Service\TextBeautify\PaddingTextBeautifierInterface;

class HeartsPaddingBeautifier implements PaddingTextBeautifierInterface
{
    public function beautify(string $text): string
    {
        return '❤'.$text.'❤';
    }

    public static function getIndex(): string
    {
        return 'hearts_padding';
    }

    public static function getPriority(): int
    {
        return 300;
    }
}
