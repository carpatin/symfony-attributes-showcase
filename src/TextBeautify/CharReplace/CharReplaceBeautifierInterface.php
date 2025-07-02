<?php

declare(strict_types=1);

namespace App\TextBeautify\CharReplace;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.text_beautifier')]
interface CharReplaceBeautifierInterface
{
    public function beautify(string $text): string;
}
