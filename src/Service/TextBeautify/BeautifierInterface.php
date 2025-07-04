<?php

declare(strict_types=1);

namespace App\Service\TextBeautify;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.text_beautifier')]
interface BeautifierInterface
{
    public function beautify(string $text): string;
}
