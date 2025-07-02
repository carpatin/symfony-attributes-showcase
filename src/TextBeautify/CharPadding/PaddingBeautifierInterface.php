<?php

declare(strict_types=1);

namespace App\TextBeautify\CharPadding;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.text_beautifier')]
interface PaddingBeautifierInterface
{
    public function beautify(string $text): string;
}
